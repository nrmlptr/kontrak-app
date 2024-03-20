<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'sap_code', 'registration_no', 'alamat', 'kode_pos', 'kota', 'provinsi', 'board_type', 'primary_data', 'full_name', 'citizenship', 'position', 'email', 'phone_number'];
}