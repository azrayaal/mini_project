<?php
// app/Http/Controllers/Api/PelangganController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log facade

class PelangganController extends Controller
{
    // Mendapatkan semua data pelanggan
    public function index()
    {
        $pelanggans = Pelanggan::all(); // Mengambil semua data dari tabel pelanggans
        return response()->json($pelanggans, 200); // Mengembalikan data dalam format JSON
    }

    // Mendapatkan satu data pelanggan berdasarkan ID
    public function show($id)
    {
        $pelanggan = Pelanggan::find($id);
        if ($pelanggan) {
            return response()->json($pelanggan, 200);
        } else {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }
    }

    // Menambahkan data pelanggan baru
    public function store(Request $request)
    {
        Log::info('Request Data:', $request->all());

        try {
            $request->validate([
                'ID_PELANGGAN' => 'required|unique:pelanggan|regex:/^PELANGGAN_\d+$/|max:300', // Perbaiki di sini
                'NAMA' => 'required|string|max:50',
                'DOMISILI' => 'required|string|max:50',
                'JENIS_KELAMIN' => 'required|string|max:10'
            ]);


            $pelanggan = Pelanggan::create($request->all());

            Log::info('Pelanggan Created:', ['pelanggan' => $pelanggan]);

            return response()->json($pelanggan, 201);
        } catch (\Exception $e) {
            Log::error('Error creating Pelanggan: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    // Mengupdate data pelanggan berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi data yang masuk
        $request->validate([
            'NAMA' => 'sometimes|required|string|max:50',
            'DOMISILI' => 'sometimes|required|string|max:50',
            'JENIS_KELAMIN' => 'sometimes|required|string|max:10'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all()); // Mengupdate data pelanggan
        return response()->json($pelanggan, 200);
    }

    // Menghapus data pelanggan berdasarkan ID
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);
        if ($pelanggan) {
            $pelanggan->delete(); // Menghapus data pelanggan
            return response()->json(['message' => 'Data pelanggan berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }
    }
}

