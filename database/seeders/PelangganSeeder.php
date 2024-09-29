<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        $pelangganData = [
            ['nama' => 'ANDI', 'domisili' => 'JAK-UT', 'jenis_kelamin' => 'PRIA'],
            ['nama' => 'BUDI', 'domisili' => 'JAK-BAR', 'jenis_kelamin' => 'PRIA'],
            ['nama' => 'JOHAN', 'domisili' => 'JAK-SEL', 'jenis_kelamin' => 'PRIA'],
            ['nama' => 'SINTHA', 'domisili' => 'JAK-TIM', 'jenis_kelamin' => 'WANITA'],
            ['nama' => 'ANTO', 'domisili' => 'JAK-UT', 'jenis_kelamin' => 'PRIA'],
            ['nama' => 'BUJANG', 'domisili' => 'JAK-BAR', 'jenis_kelamin' => 'PRIA'],
            ['nama' => 'JOWAN', 'domisili' => 'JAK-SEL', 'jenis_kelamin' => 'PRIA'],
            ['nama' => 'SINTIA', 'domisili' => 'JAK-TIM', 'jenis_kelamin' => 'WANITA'],
            ['nama' => 'BUTET', 'domisili' => 'JAK-BAR', 'jenis_kelamin' => 'WANITA'],
            ['nama' => 'JONNY', 'domisili' => 'JAK-SEL', 'jenis_kelamin' => 'WANITA']
        ];

        foreach ($pelangganData as $data) {
            Pelanggan::create($data);
        }
    }
}
