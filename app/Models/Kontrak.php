<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'detail_number', 'perihal', 'date_kontrak', 'nomor_sop', 'tanggal_sop', 'pembuat', 'unit_kerja', 'jenis_kontrak', 'status'
    ];

    public function lampiran1()
    {
        return $this->hasMany(Lampiran1::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function scopeUnitkerja($query)
    {
        return $query->where('unit_kerja', auth()->user()->unit_kerja);
    }

    public function logs()
    {
        return $this->hasMany(LogContract::class, 'kontraks_id');
    }
}
