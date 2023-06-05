<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use App\Http\Resources\PaketResource;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pakets = Paket::all();
        return PaketResource::collection($pakets);
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
            'nama_paket' => "required",
            'description' => 'required',
        ]);

        $paket = new Paket();
        $paket->nama_paket = $request->nama_paket;
        $paket->description = $request->description;


        $paket->save();

        return response()->json(['message' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket,$id)
    {
        $paket = Paket::findOrFail($id);
        return new PaketResource($paket);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paket $paket,$id)
    {
        $validation = $request->validate([
            'nama_paket' => "required",
            'description' => 'required',
        ]);

        $paket = Paket::findOrFail($id);

        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $paket->nama_paket = $request->nama_paket;
        $paket->description = $request->description;


        $paket->save();

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $paket]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket,$id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $paket->delete();
    
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
