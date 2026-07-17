
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;

// Jadikan Dashboard sebagai halaman utama aplikasi kasir Anda
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk halaman utama daftar produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// Route tambah produk (sudah kita buat sebelumnya)
Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.tambah');
Route::post('/produk/tambah', [ProdukController::class, 'store'])->name('produk.store');
// Route untuk memproses form tambah produk
Route::post('/produk/tambah', [ProdukController::class, 'store'])->name('produk.store');

// Route Edit & Update Produk
Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');

// Route Hapus Produk
Route::delete('/produk/hapus/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// Route Transaksi Kasir
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi/simpan', [TransaksiController::class, 'store'])->name('transaksi.store');

// Route untuk Cetak Struk Belanja
Route::get('/transaksi/nota/{id}', [TransaksiController::class, 'nota'])->name('transaksi.nota');

// Route untuk melihat Riwayat Transaksi
Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');