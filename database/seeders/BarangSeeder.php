<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $barangData = [
            ['nama' => 'PEN', 'kategori' => 'ATK', 'harga' => 15000],
            ['nama' => 'PENSIL', 'kategori' => 'ATK', 'harga' => 10000],
            ['nama' => 'PAYUNG', 'kategori' => 'RT', 'harga' => 70000],
            ['nama' => 'PANCI', 'kategori' => 'MASAK', 'harga' => 110000],
            ['nama' => 'SAPU', 'kategori' => 'RT', 'harga' => 40000],
            ['nama' => 'KIPAS', 'kategori' => 'ELEKTRONIK', 'harga' => 200000],
            ['nama' => 'KUALI', 'kategori' => 'MASAK', 'harga' => 120000],
            ['nama' => 'SIKAT', 'kategori' => 'RT', 'harga' => 30000],
            ['nama' => 'GELAS', 'kategori' => 'RT', 'harga' => 25000],
            ['nama' => 'PIRING', 'kategori' => 'RT', 'harga' => 35000]
        ];

        foreach ($barangData as $data) {
            Barang::create($data);
        }
    }
}
