<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Menampilkan halaman transaksi kasir
    public function index()
    {
        $produks = Produk::where('stok', '>', 0)->get();
        return view('transaksi.index', compact('produks'));
    }

    // Menyimpan transaksi baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'total_bayar' => 'required|numeric',
            'grand_total' => 'required|numeric',
        ]);

        // Menggunakan DB transaction dan menangkap ID transaksi baru
        $id_transaksi = DB::transaction(function () use ($request) {
            $transaksi = Transaksi::create([
                'tanggal_transaksi' => now(),
                'total_bayar' => $request->total_bayar,
                'diskon' => $request->diskon ?? 0,
                'pajak' => $request->pajak ?? 0,
                'grand_total' => $request->grand_total,
            ]);

            // 2. Simpan ke tabel Detail Transaksi & Kurangi Stok Produk
            foreach ($request->cart as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi stok produk di database
                $produk = Produk::find($item['id_produk']);
                if ($produk) {
                    $produk->decrement('stok', $item['jumlah']);
                }
            }
            
            return $transaksi->id_transaksi; // Kembalikan ID untuk dikirim ke frontend
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil disimpan!', // <-- Sekarang sudah ditambahkan koma di sini
            'id_transaksi' => $id_transaksi // Kirimkan ID transaksi baru ke JS
        ]);
    }

    // 2. Tambahkan fungsi baru untuk mengambil data nota
    public function nota($id)
    {
        // Mengambil transaksi dengan detail produknya
        $transaksi = Transaksi::findOrFail($id);
        $details = DetailTransaksi::with('produk')->where('id_transaksi', $id)->get();

        return view('transaksi.nota', compact('transaksi', 'details'));
    }
    // Menampilkan halaman riwayat semua transaksi
    public function riwayat(Request $request)
    {
        // Ambil query pencarian tanggal jika ada filter dari user
        $tanggal = $request->input('tanggal');

        $query = Transaksi::orderBy('tanggal_transaksi', 'desc');

        // Jika user melakukan filter berdasarkan tanggal tertentu
        if ($tanggal) {
            $query->whereDate('tanggal_transaksi', $tanggal);
        }

        $transaksis = $query->paginate(10); // Menampilkan 10 data per halaman (pagination)

        return view('transaksi.riwayat', compact('transaksis', 'tanggal'));
    }
}