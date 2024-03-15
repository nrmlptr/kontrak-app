<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'detail_number', 'perihal', 'date_kontrak', 'nomor_sop', 'tanggal_sop', 'pembuat', 'unit_kerja','jenis_kontrak', 'status'
    ];
}
