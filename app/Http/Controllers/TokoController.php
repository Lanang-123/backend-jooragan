<?php

namespace App\Http\Controllers;

use App\Http\Resources\TokoResource;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokos = Toko::all();
        return response()->json(['data' => $tokos], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

    public function getPDF($filename)
    {
        $path = storage_path('app/mou/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['message' => 'PDF not found.'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);
        $base64PDF = base64_encode($file);

        // Pastikan tipe konten adalah PDF
        if ($type !== 'application/pdf') {
            return response()->json(['message' => 'Invalid file type. Only PDF files are supported.'], 400);
        }

        return response()->json(['pdf' => $base64PDF, 'type' => $type]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama_toko' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'icons' => 'required',
            'mou' => 'required'
        ]);

        $user = Auth::user();
        $id_user = $user->id;

        $filename = $this->generateRandomString();
        $extension = $request->icons->extension();
        $mou_ext = $request->mou->extension();
        Storage::putFileAs('photos', $request->icons, $filename . '.' . $extension);
        Storage::putFileAs('mou', $request->mou, $filename . '.' . $mou_ext);

        try {
            $toko = new Toko();
            $toko->id_user = $id_user;
            $toko->nama_toko = $request->input('nama_toko');
            $toko->id_category = $request->input('id_category');
            $toko->description = $request->input('description');
            $toko->icons = $filename . '.' . $extension;
            $toko->mou_file = $filename . '.' . $mou_ext;
            $toko->save();

            $newTokoCategory = $toko->id_category;

            return response()->json(['message' => 'Data berhasil ditambahkan', 'success' => true, 'id_category' => $newTokoCategory]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Data gagal ditambahkan', 'success' => false]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showByOwner(Toko $toko)
    {
        $user = Auth::user();
        $id_user = $user->id;
        $productsOwner = Toko::where('id_user', $id_user)->get();
        return TokoResource::collection($productsOwner);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toko $toko)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Toko $toko, $id)
    {
        $validation = $request->validate([
            'nama_toko' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'icons' => 'required'
        ]);

        $toko = Toko::find($id);

        $user = Auth::user();
        $id_user = $user->id;

        if ($toko->icons) {
            Storage::delete('photos/' . $toko->icons);
        }

        $filename = $this->generateRandomString();
        $extension = $request->icons->extension();
        $mou_ext = $request->mou->extension();
        Storage::putFileAs('photos', $request->icons, $filename . '.' . $extension);
        Storage::putFileAs('mou', $request->mou, $filename . '.' . $mou_ext);
        try {
            $toko->id_user = $id_user;
            $toko->nama_toko = $request->input('nama_toko');
            $toko->id_category = $request->input('id_category');
            $toko->description = $request->input('description');
            $toko->icons = $filename . '.' . $extension;
            $toko->mou_file = $filename . '.' . $mou_ext;
            $toko->save();

            return response()->json(['message' => 'Data berhasil diupdate', 'success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Data gagal diupdate', 'success' => false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toko $toko, $id)
    {
        $toko = Toko::find($id);

        if (!$toko) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Menghapus file terkait jika ada
        if ($toko->icons) {
            Storage::delete('photos/' . $toko->icons);
        }

        $toko->delete();

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
