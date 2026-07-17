<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    
    protected $fillable = [
        'tanggal_transaksi',
        'id_pelanggan',
        'total_bayar',
        'diskon',
        'pajak',
        'grand_total'
    ];

    public $timestamps = false;

    // Relasi ke Detail Transaksi
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}