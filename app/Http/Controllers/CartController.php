<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Http\Resources\CartUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::all();
        return response()->json(['data' => $carts]);
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
            'id_user' => 'required',
            'id_product' => 'required',
            'id_paket' => 'required',
            'quantity' => 'required',
        ]);

        $cart = new Cart();
        $cart->id_user = $request->input('id_user');
        $cart->id_product = $request->input('id_product');
        $cart->id_paket = $request->input('id_paket');
        $cart->quantity = $request->input('quantity');

        $cart->save();
        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $cart]);
    }

    /**
     * Display the specified resource.
     */
    public function showByUser(Cart $cart)
    {
        $idUser = Auth::user()->id;
        $cartUser = Cart::with('user:id,name,email')->with('paket:id,nama_paket,description')->where('id_user', $idUser)->get();
        return CartUserResource::collection($cartUser);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
