
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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;

// Jadikan Dashboard sebagai halaman utama aplikasi kasir Anda
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk halaman utama daftar produk
// Menampilkan daftar produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// Menampilkan form tambah produk (Menggunakan /create agar sesuai dengan link di sidebar)
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');

// Memproses penyimpanan data produk baru ke database
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
// Route Edit & Update Produk
Route::get('/produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');

// Route Hapus Produk
Route::delete('/produk/hapus/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// Route Transaksi Kasir
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi/simpan', [TransaksiController::class, 'store'])->name('transaksi.store');

// Route untuk Cetak Struk Belanja
Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'nota'])->name('transaksi.nota');

// Route untuk melihat Riwayat Transaksi
Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');

// Rute Autentikasi (Bisa diakses tanpa login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. Alihkan halaman utama (/) ke dashboard jika sudah login, atau ke login jika belum
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// 2. Rute Aplikasi Utama yang wajib Login
Route::middleware(['auth'])->group(function () {
    
    // Bisa diakses oleh ADMIN maupun KASIR
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');

    // KHUSUS ADMIN SAJA (Kasir tidak bisa buka)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::delete('/produk/{id}', [ProdukController::class, 'hapus'])->name('produk.hapus');
    });
});