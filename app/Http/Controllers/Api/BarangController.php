<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        return response()->json(Barang::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);

        $barang = Barang::create($validated);
        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|integer',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($validated);
        return response()->json($barang);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return response()->json(['message' => 'Barang deleted successfully']);
    }
}
