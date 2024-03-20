<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran7 extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'kontraks_id', 'alamat_vendor', 'alamat_peruri'];
}
