<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // Nama tabel
    protected $primaryKey = 'KODE'; // Primary key
    public $incrementing = false; // Primary key bukan auto increment
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $timestamps = false; // Nonaktifkan timestamps otomatis

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = ['KODE', 'NAMA', 'KATEGORI', 'HARGA'];
}
