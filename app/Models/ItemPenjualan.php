<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPenjualan extends Model
{
    use HasFactory;

    protected $fillable = ['nota', 'kode_barang', 'qty'];

    // Relasi ke Penjualan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'nota');
    }

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang');
    }
}
