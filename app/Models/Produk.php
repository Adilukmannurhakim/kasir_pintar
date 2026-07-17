<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // 🌟 Beritahu Laravel nama tabel kustom kita
    protected $table = 'produk';

    // 🌟 Tentukan Primary Key tabel (default Laravel adalah 'id')
    protected $primaryKey = 'id_produk';

    // 🌟 Kolom yang boleh diisi
    protected $fillable = [
        'nama_produk',
        'harga',
        'stok'
    ];

    // Jika di tabel database-mu tidak ada kolom created_at dan updated_at, set ini ke false:
    public $timestamps = false; 
}