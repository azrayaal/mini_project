<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'domisili', 'jenis_kelamin', 'id_pelanggan'];

    public static function boot()
    {
        parent::boot();

        // Event sebelum data pelanggan dibuat
        static::creating(function ($model) {
            // Buat id_pelanggan berdasarkan id yang akan dibuat
            $latestId = self::max('id') + 1;
            $model->id_pelanggan = 'PELANGGAN_' . $latestId;
        });
    }
}
