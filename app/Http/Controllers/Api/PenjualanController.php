<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    // Mendapatkan semua data penjualan
    public function index()
    {
        $penjualans = Penjualan::all();
        return response()->json($penjualans, 200);
    }

    // Mendapatkan data penjualan berdasarkan ID_NOTA
    public function show($id)
    {
        $penjualan = Penjualan::find($id);
        if ($penjualan) {
            return response()->json($penjualan, 200);
        } else {
            return response()->json(['message' => 'Data penjualan tidak ditemukan'], 404);
        }
    }

    // Menambahkan data penjualan baru
    public function store(Request $request)
    {
        $request->validate([
            'ID_NOTA' => 'required|unique:penjualan|regex:/^NOTA_\d+$/|max:300',
            'TGL' => 'required|date',
            'KODE_PELANGGAN' => 'required|string|max:300',
            'SUBTOTAL' => 'required|integer'
        ]);

        $penjualan = Penjualan::create($request->all());
        return response()->json($penjualan, 201);
    }

    // Mengupdate data penjualan berdasarkan ID_NOTA
    public function update(Request $request, $id)
    {
        $request->validate([
            'TGL' => 'sometimes|required|date',
            'KODE_PELANGGAN' => 'sometimes|required|string|max:300',
            'SUBTOTAL' => 'sometimes|required|integer'
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $penjualan->update($request->all());
        return response()->json($penjualan, 200);
    }

    // Menghapus data penjualan berdasarkan ID_NOTA
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        if ($penjualan) {
            $penjualan->delete();
            return response()->json(['message' => 'Data penjualan berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data penjualan tidak ditemukan'], 404);
        }
    }
}
