<?php

namespace App\Http\Controllers;

use App\Models\CategoryEducation;
use Illuminate\Http\Request;

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
            'nama_category' => 'required'
        ]);
        
        $category = new CategoryEducation();
        $category->nama_category = $request->input('nama_category');
        $category->save();
        return response()->json(['message' => 'Data berhasil ditambahkan','data' => $category]);
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
            'nama_category' => 'required'
        ]);
        
        $category = CategoryEducation::find($id);
        $category->nama_category = $request->input('nama_category');
        $category->save();
        return response()->json(['message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryEducation $categoryEducation,$id)
    {
        $category = CategoryEducation::find($id);
        $category->delete();
        return response()->json(['message' => 'Data berhasil dihapus','data' => $category]);
    }
}