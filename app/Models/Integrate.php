<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'id','no_spph', 'tender_name', 'purchasing_document_number', 'document_date', 'po_delivery_date', 'vendors_account_number', 'registration_no', 'vendor_name', 'purchasing_group', 'material_number', 'material_name', 'purchase_order_quantity', 'purchase_order_unit_of_measure', 'purchase_requisition_number', 'net_price', 'alamat', 'kode_pos', 'kota', 'provinsi'
    ];
}
