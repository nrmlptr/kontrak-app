<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vendorText()
    {
        return $this->hasOne(VendorText::class, 'registration_no', 'registration_no');
    }

    public function vendor()
    {
        return $this->hasMany(Vendor::class, 'registration_no', 'registration_no');
    }

    public function purchaseRequisitions()
    {
        return $this->hasMany(Integrate::class, 'purchasing_document_number', 'purchasing_document_number');
    }


    // public function vendor_1()
    // {
    //     return $this->hasOne(Vendor::class, 'registration_no', 'registration_no'); // Sesuaikan foreign key dan local key
    // }


}
