<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan'; // Nama tabel
    protected $primaryKey = 'ID_NOTA'; // Primary key
    public $incrementing = false; // Primary key bukan auto increment
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $timestamps = false; // Nonaktifkan timestamps otomatis

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = ['ID_NOTA', 'TGL', 'KODE_PELANGGAN', 'SUBTOTAL'];
}
