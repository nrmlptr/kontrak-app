<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran2 extends Model
{
    use HasFactory;

    protected $fillable = ['id','kontraks_id', 'perihal', 'nomor_sop', 'tanggal_sop'];
}
