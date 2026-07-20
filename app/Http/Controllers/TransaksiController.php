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
        // Mengambil produk yang stoknya > 0 (SoftDeletes otomatis menyaring produk yang belum dihapus)
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

        try {
            $id_transaksi = DB::transaction(function () use ($request) {
                // 1. Simpan ke tabel Transaksi
                $transaksi = Transaksi::create([
                    'tanggal_transaksi' => now(),
                    'total_bayar'       => $request->total_bayar, 
                    'diskon'            => $request->diskon ?? 0,
                    'pajak'             => $request->pajak ?? 0,
                    'grand_total'       => $request->grand_total, 
                    'id_pelanggan'      => null,
                ]);

                // Ambil ID Transaksi yang baru disave
                $transaksiId = $transaksi->id_transaksi;

                // 2. Loop item untuk menyimpan detail dan memotong stok
                foreach ($request->cart as $item) {
                    $subtotalItem = $item['price'] * $item['qty'];

                    // Simpan Detail Transaksi
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksiId,
                        'id_produk'    => $item['id'], // ID dari JS dipetakan ke kolom id_produk
                        'jumlah'       => $item['qty'],  
                        'subtotal'     => $subtotalItem,
                    ]);

                    // Mengurangi stok produk (Menggunakan id_produk sebagai acuan sesuai model Produk)
                    $produk = Produk::find($item['id']);
                    
                    if ($produk) {
                        $produk->decrement('stok', $item['qty']);
                    }
                }
                
                return $transaksiId;
            }); // Penutup DB::transaction yang benar

            return response()->json([
                'success'      => true, 
                'message'      => 'Transaksi berhasil disimpan!',
                'id_transaksi' => $id_transaksi
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                // UBAH BARIS INI untuk memunculkan pesan error asli dari database:
                'message' => 'Error Sistem: ' . $e->getMessage() 
            ], 500);
        }
    }

    // Mengambil data nota untuk dicetak
    public function nota($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        // with('produk') akan berjalan mulus karena relasi di DetailTransaksi sudah disesuaikan
        $details = DetailTransaksi::with('produk')->where('id_transaksi', $id)->get();

        return view('transaksi.nota', compact('transaksi', 'details'));
    }

    // Menampilkan halaman riwayat semua transaksi
    public function riwayat(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $query = Transaksi::orderBy('tanggal_transaksi', 'desc');

        if ($tanggal) {
            $query->whereDate('tanggal_transaksi', $tanggal);
        }

        $transaksis = $query->paginate(10);

        return view('transaksi.riwayat', compact('transaksis', 'tanggal'));
    }
}