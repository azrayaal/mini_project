<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class ItemPenjualanController extends Controller
{
    // Menampilkan semua item penjualan
    public function index()
    {
        // Menampilkan semua item penjualan dengan relasi barang
        $items = ItemPenjualan::with('barang')->get();
        return response()->json($items);
    }
    public function addItem(Request $request, $idNota)
    {
        // Log request dan ID nota
        \Log::info("Request untuk menambahkan item ke penjualan", ['idNota' => $idNota, 'request' => $request->all()]);

        // Cari penjualan berdasarkan id_nota (string)
        $penjualan = Penjualan::where('id_nota', $idNota)->firstOrFail();

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|integer|exists:barangs,id',
            'qty' => 'required|integer|min:1',
        ]);

        // Log hasil validasi
        \Log::info("Input tervalidasi", ['validated' => $validated]);

        try {
            // Tambahkan item ke penjualan berdasarkan nota string
            $itemPenjualan = ItemPenjualan::create([
                'nota' => $penjualan->id_nota,  // Menggunakan id_nota string, bukan ID integer
                'kode_barang' => $validated['kode_barang'],
                'qty' => $validated['qty'],
            ]);

            // Log setelah item penjualan ditambahkan
            \Log::info("Item berhasil ditambahkan ke penjualan", ['item' => $itemPenjualan]);

            // Panggil metode untuk update subtotal dan tambahkan log
            $this->updateSubtotal($penjualan->id_nota);  // Menggunakan id_nota

            \Log::info("Subtotal berhasil diperbarui", ['idNota' => $idNota]);

            return response()->json($itemPenjualan, 201);
        } catch (\Exception $e) {
            // Log jika terjadi error
            \Log::error("Error saat menambahkan item ke penjualan", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menambahkan item ke penjualan'], 500);
        }
    }


    private function updateSubtotal($id_nota)
    {
        try {
            // Ambil data penjualan berdasarkan id_nota
            $penjualan = Penjualan::where('id_nota', $id_nota)->firstOrFail();

            // Hitung subtotal dari semua item yang terkait dengan penjualan ini
            $subtotal = ItemPenjualan::where('nota', $id_nota)
                ->sum(\DB::raw('qty * harga_satuan'));

            // Update subtotal pada tabel penjualan
            $penjualan->update(['subtotal' => $subtotal]);

            \Log::info('Subtotal berhasil diperbarui', ['id_nota' => $id_nota, 'subtotal' => $subtotal]);
        } catch (\Exception $e) {
            \Log::error('Error updating subtotal: ' . $e->getMessage());
        }
    }




    // Menyimpan data item penjualan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nota' => 'required|string|exists:penjualans,id_nota', // Pastikan nota valid
            'kode_barang' => 'required|string|exists:barangs,kode', // Pastikan barang valid
            'qty' => 'required|integer|min:1',
        ]);

        try {
            $barang = Barang::where('kode', $validated['kode_barang'])->firstOrFail();

            $itemPenjualan = ItemPenjualan::create([
                'nota' => $validated['nota'],
                'kode_barang' => $validated['kode_barang'],
                'qty' => $validated['qty'],
                'harga_satuan' => $barang->harga,
            ]);

            // Update subtotal pada tabel penjualan
            $this->updateSubtotal($validated['nota']);

            \Log::info('Item penjualan berhasil disimpan: ', $itemPenjualan->toArray());
            return response()->json($itemPenjualan, 201);
        } catch (\Exception $e) {
            \Log::error('Error menyimpan item penjualan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat item penjualan'], 500);
        }
    }


    // Menampilkan item penjualan berdasarkan ID
    public function show($id)
    {
        $itemPenjualan = ItemPenjualan::with('barang')->findOrFail($id);
        return response()->json($itemPenjualan);
    }

    // Menampilkan semua item penjualan berdasarkan nota
    public function getItemsByNota($nota)
    {
        $items = ItemPenjualan::where('nota', $nota)->with('barang')->get();
        $data = $items->map(function ($item) {
            return [
                'nota' => $item->nota,
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->barang->nama,
                'qty' => $item->qty,
                'harga_satuan' => $item->barang->harga,
                'total_harga' => $item->qty * $item->barang->harga
            ];
        });

        return response()->json($data);
    }


    // Menghapus item penjualan
    public function destroy($id)
    {
        try {
            // Find the item penjualan by its ID
            $itemPenjualan = ItemPenjualan::findOrFail($id);
            $nota = $itemPenjualan->nota; // Get the related nota (ID Nota)

            // Delete the item
            $itemPenjualan->delete();

            // Update the subtotal for the penjualan after item deletion
            $this->updateSubtotal($nota);

            // Return a success response
            return response()->json(['message' => 'Item Penjualan deleted successfully'], 200);
        } catch (\Exception $e) {
            // If there is an error, log it and return a failure response
            \Log::error('Error deleting item penjualan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghapus item penjualan'], 500);
        }
    }


}
