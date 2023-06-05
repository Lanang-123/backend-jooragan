<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json(['data' => $orders]);
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
            'id_produk' => 'required',
            'total' => 'required'
        ]);

        $order = new Order();
        $order->id_user = $request->input('id_user');
        $order->id_produk = $request->input('id_produk');
        $order->total = $request->input('total');
        $order->save();
        return response()->json(['message' => 'Data berhasil ditambahkan','data' => $order]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order,$id)
    {
        $validation = $request->validate([
            'id_user' => 'required',
            'id_produk' => 'required',
            'total' => 'required'
        ]);

        $order = Order::find($id);
        $order->id_user = $request->input('id_user');
        $order->id_produk = $request->input('id_produk');
        $order->total = $request->input('total');
        $order->save();
        return response()->json(['message' => 'Data berhasil diubah','data' => $order]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order,$id)
    {
        $order = Order::find($id);
        $order->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}