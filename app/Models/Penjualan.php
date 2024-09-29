<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['tgl', 'kode_pelanggan', 'subtotal', 'id_nota'];

    public static function boot()
    {
        parent::boot();

        // Event sebelum data penjualan dibuat
        static::creating(function ($model) {
            // Buat id_nota berdasarkan id yang akan dibuat
            $latestId = self::max('id') + 1;
            $model->id_nota = 'NOTA_' . $latestId;
        });
    }

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'kode_pelanggan');
    }

    // Relasi ke ItemPenjualan
    public function itemPenjualans()
    {
        // return $this->hasMany(ItemPenjualan::class, 'nota');
        return $this->hasMany(ItemPenjualan::class, 'nota', 'id_nota');
    }
}
