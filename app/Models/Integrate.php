<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'no_spph', 'no_sp3', 'tgl_sp3_approve', 'schedule_from_time', 'schedule_thru_time', 'tender_name', 'purchasing_document_number', 'document_date', 'po_delivery_date', 'vendors_account_number', 'registration_no', 'vendor_name', 'purchasing_document_type', 'purchasing_group', 'material_group', 'material_number', 'material_name', 'purchase_requisition_number', 'item_number_of_purchasing_document', 'purchase_order_quantity', 'purchase_order_unit_of_measure', 'net_price', 'condition_value', 'alamat', 'kode_pos', 'kota', 'provinsi'
    ];
}
