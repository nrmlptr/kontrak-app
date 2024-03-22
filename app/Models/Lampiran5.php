<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran5 extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'kontraks_id', 'no_sppb', 'nama_barang', 'satuan', 'harga_awal', 'qty', 'ppn', 'harga_akhir'];

}
