<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\CategoryEducation;
use Illuminate\Http\Request;
use App\Http\Resources\EducationResource;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $educations = Education::all();
        return response()->json(['data' => $educations]);
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
            'id_category_education' => 'required',
            'name_education' => 'required',
            'description' => 'required',
            'video_path' => 'required|mimetypes:video/mp4' // Menambahkan validasi tipe file dan ukuran maksimum
        ]);

        $education = new Education();
        $education->id_category_education = $request->input('id_category_education');
        $education->name_education = $request->input('name_education');
        $education->description = $request->input('description');

        // Menyimpan video
        if ($request->hasFile('video_path')) {
            $video = $request->file('video_path');

            $path = $video->store('public/videos'); // Simpan video dalam direktori 'public/videos' di penyimpanan

            // Mendapatkan nama file yang disimpan
            $filename = basename($path);

            // Menyimpan nama file ke dalam atribut 'video_path' pada model Education
            $education->video_path = $filename;
        }

        // Simpan ke database
        $education->save();

        // Redirect atau tindakan lain setelah penyimpanan berhasil
        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $education]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education, $id)
    {
        $education = Education::find($id);
        $idCategory = CategoryEducation::find($education->id_category_education);
        return response()->json([
            'data' => $education,
            'category' => $idCategory
        ]);
    }

    public function showByCategory($id)
    {
        $educations = Education::where('id_category_education', $id)->get();
        return response()->json(['data' => $educations]);
    }

    public function getVideo($video_path)
    {
        $path = storage_path('app/public/videos/' . $video_path);

        if (!file_exists($path)) {
            return response()->json(['message' => 'Video not found.'], 404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header('Content-Type', $type);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'id_category_education' => 'required',
            'name_education' => 'required',
            'description' => 'required',
            'video_path' => 'required|mimetypes:video/mp4|max:50000' // Menambahkan validasi tipe file dan ukuran maksimum
        ]);

        $education = Education::findOrFail($id);
        $education->id_category_education = $request->input('id_category_education');
        $education->name_education = $request->input('name_education');
        $education->description = $request->input('description');




        // Menyimpan video baru
        if ($request->hasFile('video_path')) {
            $video = $request->file('video_path');

            $videoPath = $request->file('video_path')->path();
            if (Storage::exists($videoPath)) {
                Storage::delete($videoPath);
            }


            $path = $video->store('public/videos');

            $filename = basename($path);
            $education->video_path = $filename;
        }

        // Simpan perubahan ke database
        $education->save();

        // Redirect atau tindakan lain setelah pembaruan berhasil
        return response()->json(['message' => 'Data berhasil diupdate']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education, $id)
    {
        $education = Education::findOrFail($id);

        // Hapus video terkait
        $this->deleteVideo($education->video_path);

        // Hapus entitas Education dari database
        $education->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
