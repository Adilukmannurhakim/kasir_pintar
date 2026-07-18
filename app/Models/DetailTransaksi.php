<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';

    public $timestamps = true;
    
    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'subtotal'
    ];
// Hubungan ke tabel Transaksi (Setiap detail dimiliki oleh satu transaksi)
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}