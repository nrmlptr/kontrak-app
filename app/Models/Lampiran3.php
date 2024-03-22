<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran3 extends Model
{
    use HasFactory;

    protected $fillable = ['id','kontraks_id','jenis_spesifikasi','gambar','spesifikasi_teknis','no_sppb','kode_barang','jenis_barang','satuan'];

}
