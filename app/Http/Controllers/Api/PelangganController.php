<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return response()->json(Pelanggan::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'domisili' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:10',
        ]);

        $pelanggan = Pelanggan::create($validated);
        return response()->json($pelanggan, 201);
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return response()->json($pelanggan);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'domisili' => 'sometimes|required|string|max:255',
            'jenis_kelamin' => 'sometimes|required|string|max:10',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($validated);
        return response()->json($pelanggan);
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return response()->json(['message' => 'Pelanggan deleted successfully']);
    }
}
