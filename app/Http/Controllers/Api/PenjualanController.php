<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log
use App\Models\ItemPenjualan;
use App\Models\Barang;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    // Menampilkan semua penjualan
    public function index()
    {
        try {
            $penjualans = Penjualan::with(['pelanggan', 'itemPenjualans.barang'])->get();

            $data = $penjualans->map(function ($penjualan) {
                // Jika subtotal adalah 0, hitung ulang dari item_penjualans
                // if ($penjualan->subtotal == 0) {
                //     $penjualan->subtotal = $penjualan->itemPenjualans->sum(function ($item) {
                //         return $item->qty * $item->barang->harga;
                //     });
                // }

                $subtotal = $penjualan->itemPenjualans->sum(function ($item) {
                    return $item->qty * $item->barang->harga;
                });

                $penjualan->update(['subtotal' => $subtotal]);
                return [
                    'id' => $penjualan->id,
                    'nota' => $penjualan->id_nota,
                    'tgl' => $penjualan->tgl,
                    'pelanggan' => [
                        'kode_pelanggan' => $penjualan->kode_pelanggan,
                        'nama' => $penjualan->pelanggan->nama,
                    ],
                    'items' => $penjualan->itemPenjualans->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'kode_barang' => $item->kode_barang,
                            'nama_barang' => $item->barang->nama,
                            'qty' => $item->qty,
                            'harga_satuan' => $item->barang->harga,
                            'total_harga' => $item->qty * $item->barang->harga,
                        ];
                    }),
                    // 'subtotal' => $penjualan->subtotal,

                    'subtotal' => $subtotal,

                ];
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching penjualan data: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil data penjualan!'], 500);
        }
    }

    public function show($id_nota)
    {
        try {
            Log::info('Mengambil data penjualan untuk nota: ' . $id_nota);

            $penjualan = Penjualan::with(['pelanggan', 'itemPenjualans.barang'])
                ->where('id_nota', $id_nota)
                ->firstOrFail();

            $data = [
                'nota' => $penjualan->id_nota,
                'tgl' => $penjualan->tgl,
                'pelanggan' => [
                    'kode_pelanggan' => $penjualan->pelanggan->kode_pelanggan,
                    'nama' => $penjualan->pelanggan->nama,
                ],
                'items' => $penjualan->itemPenjualans->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'kode_barang' => $item->barang->kode,
                        'nama_barang' => $item->barang->nama,
                        'qty' => $item->qty,
                        'harga_satuan' => $item->barang->harga,
                        'total_harga' => $item->qty * $item->barang->harga,
                    ];
                }),
                'subtotal' => $penjualan->itemPenjualans->sum(function ($item) {
                    return $item->qty * $item->barang->harga;
                }),
            ];

            Log::info('Berhasil mengambil detail penjualan', ['penjualan' => $data]);
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching penjualan detail: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil detail penjualan!'], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi input request
        $validated = $request->validate([
            'kode_pelanggan' => 'required|integer|exists:pelanggans,id', // Validasi kode_pelanggan harus integer
        ]);

        \Log::info('Memvalidasi input penjualan', $validated);

        try {
            // Ambil id terakhir dari penjualan dan buat id_nota baru
            $lastNota = Penjualan::latest()->first();
            $nextId = $lastNota ? $lastNota->id + 1 : 1;
            $id_nota = 'NOTA_' . $nextId;

            // Buat penjualan baru dengan `tgl` otomatis dari `now()`
            $penjualan = Penjualan::create([
                'id_nota' => $id_nota,
                'tgl' => Carbon::now()->format('Y-m-d'), // Menggunakan waktu sekarang sebagai `tgl`
                'kode_pelanggan' => $validated['kode_pelanggan'], // Pastikan `kode_pelanggan` diisi dengan integer id dari pelanggan
                'subtotal' => 0, // Subtotal awal diisi 0
            ]);

            \Log::info('Data penjualan berhasil disimpan: ', $penjualan->toArray());

            return response()->json($penjualan, 201);
        } catch (\Exception $e) {
            \Log::error('Error menyimpan data penjualan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat penjualan'], 500);
        }
    }

    public function update(Request $request, $id_nota)
    {
        $validated = $request->validate([
            'kode_pelanggan' => 'required|integer|exists:pelanggans,id', // Pastikan ini sesuai tipe data yang benar
        ]);

        try {
            $penjualan = Penjualan::where('id_nota', $id_nota)->firstOrFail();

            $penjualan->update([
                'kode_pelanggan' => $validated['kode_pelanggan'],
            ]);

            \Log::info('Data penjualan berhasil diperbarui: ', $penjualan->toArray());

            return response()->json($penjualan);
        } catch (\Exception $e) {
            \Log::error('Error mengupdate data penjualan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengupdate penjualan'], 500);
        }
    }

    private function updateSubtotalPenjualan($id_nota)
    {
        try {
            Log::info('Mengupdate subtotal untuk nota: ' . $id_nota);

            $penjualan = Penjualan::where('id_nota', $id_nota)->firstOrFail();
            $subtotal = ItemPenjualan::where('nota', $id_nota)->sum(\DB::raw('qty * harga_satuan'));

            $penjualan->update(['subtotal' => $subtotal]);
            Log::info('Subtotal berhasil diperbarui', ['id_nota' => $id_nota, 'subtotal' => $subtotal]);
        } catch (\Exception $e) {
            Log::error('Error updating subtotal: ' . $e->getMessage());
        }
    }

    // Menghapus data penjualan
    public function destroy($id)
    {
        try {
            Log::info('Menghapus penjualan dengan id: ' . $id);

            $penjualan = Penjualan::findOrFail($id);
            $penjualan->delete();

            Log::info('Penjualan berhasil dihapus', ['id' => $id]);
            return response()->json(['message' => 'Penjualan deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting penjualan: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghapus data penjualan!'], 500);
        }
    }
}
