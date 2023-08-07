<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama_category' => 'required',
            'icon' => 'required'
        ]);

        $filename = $this->generateRandomString();
        $extension = $request->icon->extension();
        Storage::putFileAs('photos', $request->icon, $filename . '.' . $extension);

        $category = new Category();
        $category->nama_category = $request->input('nama_category');
        $category->icon = $filename . '.' . $extension;

        $category->save();
        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    public function getIcons($filename)
    {
        $path = storage_path('app/photos/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header('Content-Type', $type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, $id)
    {
        $validation = $request->validate([
            'nama_category' => 'required',
        ]);


        $category = Category::find($id);


        if (!$category) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($request->hasFile('icon')) {
            $filename = $this->generateRandomString();
            $extension = $request->icon->extension();

            // Hapus file icon lama jika ada
            if ($category->icon) {
                Storage::delete('photos/' . $category->icon);
            }

            Storage::putFileAs('photos', $request->icon, $filename . '.' . $extension);
            $category->icon = $filename . '.' . $extension;
        }

        $category->nama_category = $request->input('nama_category');

        $category->save();
        return response()->json(['message' => 'Data berhasil diubah', 'data' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
