<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    // 🌟 Tambahkan fungsi baru ini di paling atas
    public function index()
    {
        // Mengambil semua data produk dari database
        $produks = Produk::all();
        
        // Kirim data ke view index
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:100',
            'stok'        => 'required|numeric|min:0',
        ]);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
        ]);

        // 🌟 Ubah redirect-nya ke halaman index agar setelah sukses langsung ke daftar produk
        return redirect()->route('produk.index')->with('sukses', 'Produk berhasil ditambahkan!');
    }
    // 1. Menampilkan form edit produk dengan data lama
public function edit($id)
{
    $produk = Produk::findOrFail($id);
    return view('produk.edit', compact('produk'));
}

// 2. Memproses perubahan data produk
public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga'       => 'required|numeric|min:100',
        'stok'        => 'required|numeric|min:0',
    ]);

    $produk = Produk::findOrFail($id);
    $produk->update([
        'nama_produk' => $request->nama_produk,
        'harga'       => $request->harga,
        'stok'        => $request->stok,
    ]);

    return redirect()->route('produk.index')->with('sukses', 'Data produk berhasil diperbarui!');
}

// 3. Menghapus produk dari database
public function destroy($id)
{
    $produk = Produk::findOrFail($id);
    $produk->delete();

    return redirect()->route('produk.index')->with('sukses', 'Produk berhasil dihapus!');
}
}