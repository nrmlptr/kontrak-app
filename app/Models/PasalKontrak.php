<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasalKontrak extends Model
{
    use HasFactory;

    protected $table = 'pasal-kontrak';

    protected $fillable = ['id', 'nama_pasal', 'keterangan_pasal', 'isi_pasal', 'jenis_pasal'];
}
