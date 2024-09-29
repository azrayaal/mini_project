<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\Pelanggan;

class PenjualanSeeder extends Seeder
{
    public function run()
    {
        $penjualanData = [
            ['tgl' => '2024-01-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_1')->first()->id, 'subtotal' => 50000],
            ['tgl' => '2024-01-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_2')->first()->id, 'subtotal' => 200000],
            ['tgl' => '2024-01-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_3')->first()->id, 'subtotal' => 430000],
            ['tgl' => '2024-02-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_7')->first()->id, 'subtotal' => 120000],
            ['tgl' => '2024-02-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_4')->first()->id, 'subtotal' => 70000],
            ['tgl' => '2024-03-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_8')->first()->id, 'subtotal' => 230000],
            ['tgl' => '2024-03-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_9')->first()->id, 'subtotal' => 390000],
            ['tgl' => '2024-03-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_5')->first()->id, 'subtotal' => 65000],
            ['tgl' => '2024-04-01', 'kode_pelanggan' => Pelanggan::where('id_pelanggan', 'PELANGGAN_2')->first()->id, 'subtotal' => 40000]
        ];

        foreach ($penjualanData as $data) {
            Penjualan::create($data);
        }
    }
}
