<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kontrak;


class Lampiran1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'kontraks_id', 'data_json'
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontraks_id');
    }
}
