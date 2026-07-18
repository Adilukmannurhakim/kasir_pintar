<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan ini

class Produk extends Model
{
    use SoftDeletes; // Tambahkan ini

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    
    // Pastikan kolom deleted_at didaftarkan jika diperlukan
    protected $dates = ['deleted_at'];
    
    protected $fillable = ['nama_produk', 'harga', 'stok'];

    // Jika di tabel database-mu tidak ada kolom created_at dan updated_at, set ini ke false:
    public $timestamps = false; 
}