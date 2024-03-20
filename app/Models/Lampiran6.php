<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran6 extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'kontraks_id', 'nomor_sop', 'tanggal_sop', 'no_kontrak', 'date_kontrak', 'jenis_pembayaran', 'lama_pembayaran'];

}
