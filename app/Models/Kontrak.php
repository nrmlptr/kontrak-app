<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'kontraks'; // Sesuaikan nama tabel dengan nama sebenarnya


    public function lampiran1()
    {
        return $this->hasOne(Lampiran1::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function lampiran2()
    {
        return $this->hasOne(Lampiran2::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function lampiran3()
    {
        return $this->hasMany(Lampiran3::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }
    public function lampiran4()
    {
        return $this->hasMany(Lampiran4::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }
    public function lampiran5()
    {
        return $this->hasMany(Lampiran5::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }
    public function lampiran6()
    {
        return $this->hasOne(Lampiran6::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function lampiran7()
    {
        return $this->hasOne(Lampiran7::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function revisiKontraks()
    {
        return $this->hasMany(RevisiKontrak::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function scopeUnitkerja($query)
    {
        return $query->where('unit_kerja', auth()->user()->unit_kerja);
    }

    public function logs()
    {
        return $this->hasMany(LogContract::class, 'kontraks_id')->orderBy('created_at', 'DESC');
    }

    public function pasal()
    {
        return $this->hasMany(PasalKontrak::class, 'jenis_kontrak', 'jenis_kontrak')
            ->where('status_jaminan', $this->status_jaminan);
    }

    public function integrates()
    {
        return $this->hasMany(Integrate::class, 'purchasing_document_number', 'nomor_sop');
    }

    public function historyRevisi()
    {
        return $this->hasMany(RevisiKontrak::class, 'kontraks_id')->orderBy('created_at', 'DESC');
    }



    public function viewBYdate($date)
    {
        return Kontrak::whereDate('date_kontrak', $date)->get();
    }

    public function viewBYmonth($month, $year)
    {
        return Kontrak::whereMonth('date_kontrak', $month)
            ->whereYear('date_kontrak', $year)
            ->get();
    }

    public function viewBYyear($year)
    {
        return Kontrak::whereYear('date_kontrak', $year)->get();
    }


    public function viewALL()
    {
        return static::all(); // Menggunakan metode all() untuk mengambil semua data kontrak
    }

    public function optionTahun()
    {
        return Kontrak::selectRaw('YEAR(date_kontrak) AS tahun')
            ->orderByRaw('YEAR(date_kontrak)')
            ->groupByRaw('YEAR(date_kontrak)')
            ->get();
    }
}
