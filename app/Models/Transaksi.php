<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    // Beritahu Laravel bahwa primary key berupa Integer + Auto Increment
    public $incrementing = true;
    protected $keyType = 'int';

    // Matikan timestamps karena kolom created_at & updated_at tidak ada
    public $timestamps = false; 

    protected $fillable = [
        'tanggal_transaksi',
        'total_bayar',
        'diskon',
        'pajak',
        'grand_total',
        'id_pelanggan'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}