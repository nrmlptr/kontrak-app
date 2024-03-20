<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class revisiKontrak extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'kontraks_id', 'revisi'];
}
