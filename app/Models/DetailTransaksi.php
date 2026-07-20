<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    
    // Jika tabel detail menggunakan id_detail sebagai primary key kustom
    protected $primaryKey = 'id_detail'; 
    public $incrementing = true;
    protected $keyType = 'int';

    // Matikan timestamps karena kolom created_at & updated_at tidak ada
    public $timestamps = false; 

    protected $fillable = [
        'id_transaksi',
        'id_produk', // Berpasangan dengan id_produk di tabel produk
        'jumlah',
        'subtotal'
    ];

    /**
     * Relasi ke model Produk (Disesuaikan dengan primary key Produk.php)
     */
    public function produk()
    {
        // Parameter ke-2: foreign key di tabel detail_transaksi ('id_produk')
        // Parameter ke-3: owner key di tabel produk ('id_produk')
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk')
                    ->withDefault([
                        'nama_produk' => 'Produk Tidak Ditemukan / Dihapus',
                        'harga' => 0
                    ]);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}