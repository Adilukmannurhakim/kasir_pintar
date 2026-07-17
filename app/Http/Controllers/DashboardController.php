<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // 1. Statistik Hari Ini
        $omzetHariIni = Transaksi::whereDate('tanggal_transaksi', $hariIni)->sum('grand_total');
        $transaksiHariIni = Transaksi::whereDate('tanggal_transaksi', $hariIni)->count();
        $produkTerjualHariIni = DetailTransaksi::whereHas('transaksi', function($query) use ($hariIni) {
            $query->whereDate('tanggal_transaksi', $hariIni);
        })->sum('jumlah');

        // 2. Data Grafik Penjualan (7 Hari Terakhir)
        $grafikData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $totalPendapatan = Transaksi::whereDate('tanggal_transaksi', $tanggal)->sum('grand_total');
            
            $grafikData['labels'][] = $tanggal->translatedFormat('d M'); // Contoh: "17 Jul"
            $grafikData['data'][] = $totalPendapatan;
        }

        // 3. 5 Transaksi Terbaru hari ini
        $transaksiTerbaru = Transaksi::orderBy('tanggal_transaksi', 'desc')
                                      ->limit(5)
                                      ->get();

        return view('dashboard', compact(
            'omzetHariIni', 
            'transaksiHariIni', 
            'produkTerjualHariIni', 
            'grafikData',
            'transaksiTerbaru'
        ));
    }
}