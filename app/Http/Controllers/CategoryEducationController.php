<?php

namespace App\Http\Controllers;

use App\Models\CategoryEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = CategoryEducation::all();
        return response()->json(['data' => $category]);
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
            'nama_education' => 'required',
            'images' => 'required'
        ]);

        $filename = $this->generateRandomString();
        $extension = $request->images->extension();
        Storage::putFileAs('photos', $request->images, $filename.'.'.$extension);
        
        $category = new CategoryEducation();
        $category->nama_education = $request->input('nama_education');
        $category->images = $filename.'.'.$extension;
        $category->save();
        return response()->json(['message' => 'Data berhasil ditambahkan','data' => $category]);
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
    public function show(CategoryEducation $categoryEducation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryEducation $categoryEducation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryEducation $categoryEducation,$id)
    {
        $validation = $request->validate([
            'nama_education' => 'required',
            'images' => 'required'
        ]);
        
        $category = CategoryEducation::find($id);

         if (!$category) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    
        $filename = $this->generateRandomString();
        $extension = $request->images->extension();
        
        // Menghapus file lama jika ada
        if ($category->images) {
            Storage::delete('photos/' . $category->images);
        }
        
        Storage::putFileAs('photos', $request->images, $filename.'.'.$extension);

        $category->nama_education = $request->input('nama_education');
        $category->images = $filename.'.'.$extension;
        $category->save();
        return response()->json(['message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryEducation $categoryEducation,$id)
    {
        $category = CategoryEducation::find($id);
        if ($category->images) {
            Storage::delete('photos/' . $category->images);
        }
        $category->delete();
        return response()->json(['message' => 'Data berhasil dihapus','data' => $category]);
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