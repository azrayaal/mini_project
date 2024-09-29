<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Barang;

class ItemPenjualanSeeder extends Seeder
{
    public function run()
    {
        $itemPenjualanData = [
            ['nota' => 'NOTA_1', 'kode_barang' => Barang::where('kode', 'BRG_1')->first()->id, 'qty' => 2],
            ['nota' => 'NOTA_1', 'kode_barang' => Barang::where('kode', 'BRG_6')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_2', 'kode_barang' => Barang::where('kode', 'BRG_2')->first()->id, 'qty' => 2],
            ['nota' => 'NOTA_2', 'kode_barang' => Barang::where('kode', 'BRG_6')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_3', 'kode_barang' => Barang::where('kode', 'BRG_4')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_3', 'kode_barang' => Barang::where('kode', 'BRG_7')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_4', 'kode_barang' => Barang::where('kode', 'BRG_9')->first()->id, 'qty' => 2],
            ['nota' => 'NOTA_4', 'kode_barang' => Barang::where('kode', 'BRG_10')->first()->id, 'qty' => 2],
            ['nota' => 'NOTA_5', 'kode_barang' => Barang::where('kode', 'BRG_3')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_6', 'kode_barang' => Barang::where('kode', 'BRG_7')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_6', 'kode_barang' => Barang::where('kode', 'BRG_5')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_6', 'kode_barang' => Barang::where('kode', 'BRG_3')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_7', 'kode_barang' => Barang::where('kode', 'BRG_6')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_7', 'kode_barang' => Barang::where('kode', 'BRG_7')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_7', 'kode_barang' => Barang::where('kode', 'BRG_8')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_8', 'kode_barang' => Barang::where('kode', 'BRG_5')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_8', 'kode_barang' => Barang::where('kode', 'BRG_9')->first()->id, 'qty' => 1],
            ['nota' => 'NOTA_9', 'kode_barang' => Barang::where('kode', 'BRG_5')->first()->id, 'qty' => 1],
        ];

        foreach ($itemPenjualanData as $data) {
            ItemPenjualan::create($data);
        }
    }
}
