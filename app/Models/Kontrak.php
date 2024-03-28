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

    public function lampiran1()
    {
        return $this->hasOne(Lampiran1::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function L1()
    {
        return $this->hasMany(Lampiran1::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function lampiran2()
    {
        return $this->hasOne(Lampiran2::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function L2()
    {
        return $this->hasMany(Lampiran2::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
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

    public function L6()
    {
        return $this->hasMany(Lampiran6::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function lampiran7()
    {
        return $this->hasOne(Lampiran7::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
    }

    public function L7()
    {
        return $this->hasMany(Lampiran7::class, 'kontraks_id'); // Menentukan kunci asing secara eksplisit
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
        return $this->hasMany(PasalKontrak::class, 'jenis_pasal', 'jenis_kontrak');
    }
    public function integrates()
    {
        return $this->hasMany(Integrate::class, 'purchasing_document_number', 'nomor_sop');
    }


    // Override method delete untuk menghapus data kontrak beserta data yang terikat dengan kontraks_id ========================
    public function delete()
    {
        // Hapus lampiran 
        $this->L1()->delete();
        $this->L2()->delete();
        $this->lampiran3()->delete();
        $this->lampiran4()->delete();
        $this->lampiran5()->delete();
        $this->L6()->delete();
        $this->L7()->delete();

        // Hapus revisi kontrak 
        $this->revisiKontraks()->delete();

        // Hapus kontrak 
        return parent::delete();
    }
}
