<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('franchisor:id,name,email')->with('product')->get();
        return ReviewResource::collection($reviews);
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
            'id_product' => 'required',
            'comment' => 'required',
            'rating' => 'required'
        ]);

        $review = new Review();
        if (Auth::check()) {
            $loggedInUserId = Auth::id();
            $review->id_user = $loggedInUserId;
        } else {
            return response()->json(['message' => "Silahkan login terlebih dahulu"], 400);
        }
        $review->id_product = $request->id_product;
        $review->comment = $request->comment;
        $review->rating = $request->rating;

        $review->save();
        return response()->json(['message' => 'Data berhasil ditambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = Review::with('franchisor:id,name,email')->with('product')->find($id);
        return new ReviewResource($review);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'id_product' => 'required',
            'comment' => 'required',
            'rating' => 'required'
        ]);

        $review = Review::find($id);
        if (Auth::check()) {
            $loggedInUserId = Auth::id();
            $review->id_user = $loggedInUserId;
        } else {
            return response()->json(['message' => "Silahkan login terlebih dahulu"], 400);
        }
        $review->id_product = $request->id_product;
        $review->comment = $request->comment;
        $review->rating = $request->rating;

        $review->save();
        return response()->json(['message' => 'Data berhasil diupdate'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $review->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
