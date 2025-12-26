<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\DetailPenjualanController;
use App\Http\Controllers\Api\StokBarangController;

Route::apiResource('barang', BarangController::class);
Route::apiResource('pelanggan', PelangganController::class);
Route::apiResource('pegawai', PegawaiController::class);
Route::apiResource('penjualan', PenjualanController::class);
Route::apiResource('detail-penjualan', DetailPenjualanController::class);
Route::apiResource('stok-barang', StokBarangController::class);
