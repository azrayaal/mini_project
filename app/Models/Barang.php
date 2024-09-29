<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kategori', 'harga', 'kode'];

    public static function boot()
    {
        parent::boot();

        // Event sebelum data barang dibuat
        static::creating(function ($model) {
            // Buat kode barang berdasarkan id yang akan dibuat
            $latestId = self::max('id') + 1;
            $model->kode = 'BRG_' . $latestId;
        });
    }
}
