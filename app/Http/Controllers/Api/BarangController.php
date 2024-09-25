<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Mendapatkan semua data barang
    public function index()
    {
        $barangs = Barang::all();
        return response()->json($barangs, 200);
    }

    // Mendapatkan data barang berdasarkan KODE
    public function show($id)
    {
        $barang = Barang::find($id);
        if ($barang) {
            return response()->json($barang, 200);
        } else {
            return response()->json(['message' => 'Data barang tidak ditemukan'], 404);
        }
    }

    // Menambahkan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'KODE' => 'required|unique:barang|max:300',
            'NAMA' => 'required|string|max:50',
            'KATEGORI' => 'required|string|max:20',
            'HARGA' => 'required|integer'
        ]);

        $barang = Barang::create($request->all());
        return response()->json($barang, 201);
    }

    // Mengupdate data barang berdasarkan KODE
    public function update(Request $request, $id)
    {
        $request->validate([
            'NAMA' => 'sometimes|required|string|max:50',
            'KATEGORI' => 'sometimes|required|string|max:20',
            'HARGA' => 'sometimes|required|integer'
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return response()->json($barang, 200);
    }

    // Menghapus data barang berdasarkan KODE
    public function destroy($id)
    {
        $barang = Barang::find($id);
        if ($barang) {
            $barang->delete();
            return response()->json(['message' => 'Data barang berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data barang tidak ditemukan'], 404);
        }
    }
}
