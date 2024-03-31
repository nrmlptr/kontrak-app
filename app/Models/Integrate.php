<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrate extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function vendortext()
    {
        return $this->hasOne(VendorText::class, 'registration_no', 'registration_no');
    }
    public function vendor()
    {
        return $this->hasMany(Vendor::class, 'registration_no', 'registration_no');
    }
}
