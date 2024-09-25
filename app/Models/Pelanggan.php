<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; // Nama tabel yang benar
    protected $primaryKey = 'ID_PELANGGAN'; // Primary key di tabel
    public $incrementing = false; // Primary key bukan auto increment
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $timestamps = false; // Nonaktifkan timestamps

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = ['ID_PELANGGAN', 'NAMA', 'DOMISILI', 'JENIS_KELAMIN'];
}