<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Product::all();
        return ProductResource::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'id_category' => 'required',
            'id_user' => 'required',
            'id_paket' => 'required',
            'title' => 'required',
            'file' => 'required',
            'price' => 'required',
            'sold' => 'required',
            'stock' => 'required',
            'rating' => 'required',
            'location' => 'required',
            'description' => 'required',
        ]);

        $filename = $this->generateRandomString();
        $extension = $request->file->extension();
        Storage::putFileAs('photos', $request->file, $filename.'.'.$extension);

        $product = new Product();
        $product->id_category = $request->input('id_category');
        $product->id_user = $request->input('id_user');
        $product->id_paket = $request->input('id_paket');
        $product->title = $request->input('title');
        $product->images = $filename.'.'.$extension;
        $product->price = $request->input('price');
        $product->sold = $request->input('sold');
        $product->stock = $request->input('stock');
        $product->rating = $request->input('rating');
        $product->location = $request->input('location');
        $product->description = $request->input('description');

        $product->save();

        return response()->json(['message' => 'Data berhasil ditambahkan','data' => $product]);
    }

    public function getImage($filename) {
        $path = storage_path('app/photos/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header('Content-Type', $type);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product,$id)
    {
        $product = Product::with('category:id,nama_category')->with('franchisor:id,name')->with('paket:id,nama_paket')->with('reviews:id_user,comment,rating')->find($id);
        return new ProductDetailResource($product);
    }

    public function showByCategory($id_category) {
        $products = Product::where('id_category',$id_category)->get();
        return ProductResource::collection($products);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product,$id)
    {
        $request->validate([
            'id_category' => 'required',
            'id_user' => 'required',
            'id_paket' => 'required',
            'title' => 'required',
            'file' => 'required',
            'price' => 'required',
            'sold' => 'required',
            'stock' => 'required',
            'rating' => 'required',
            'location' => 'required',
            'description' => 'required',
        ]);
    
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        $filename = $this->generateRandomString();
        $extension = $request->file->extension();
        
        // Menghapus file lama jika ada
        if ($product->images) {
            Storage::delete('photos/' . $product->images);
        }
        
        Storage::putFileAs('photos', $request->file, $filename.'.'.$extension);
    
        $product->id_category = $request->input('id_category');
        $product->id_user = $request->input('id_user');
        $product->id_paket = $request->input('id_paket');
        $product->title = $request->input('title');
        $product->images = $filename.'.'.$extension;
        $product->price = $request->input('price');
        $product->sold = $request->input('sold');
        $product->stock = $request->input('stock');
        $product->rating = $request->input('rating');
        $product->location = $request->input('location');
        $product->description = $request->input('description');
    
        $product->save();
    
        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product,$id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        // Menghapus file terkait jika ada
        if ($product->images) {
            Storage::delete('photos/' . $product->images);
        }
    
        $product->delete();
    
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}