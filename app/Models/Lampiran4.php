<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran4 extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'kontraks_id', 'nomor_sop', 'tanggal_sop', 'jadwal_penyerahan_barang', 'lokasi'];
}
