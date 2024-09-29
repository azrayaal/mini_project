<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\ItemPenjualanController;

// Rute resource untuk Pelanggan
Route::resource('pelanggan', PelangganController::class);

// Rute resource untuk Penjualan
Route::resource('penjualan', PenjualanController::class);

// Rute resource untuk Barang
Route::resource('barang', BarangController::class);


// Rute resource untuk Item Penjualan
// Rute khusus untuk mendapatkan item penjualan berdasarkan nota
Route::get('item-penjualan/nota/{nota}', [ItemPenjualanController::class, 'getItemsByNota']);
Route::resource('item-penjualan', ItemPenjualanController::class);
Route::post('/penjualan/{idNota}/items', [ItemPenjualanController::class, 'addItem']);
