<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagingForm extends Model
{
    protected $fillable = [
        'user_id',
        'supplier_name',
        'npwp_number',
        'po_invoice_number',
        'packaging_list',
        'vehicle_registration_number',
        'total_packages',
        'total_types',
        'gross_weight',
        'hs_code',
        'item_name',
        'item_code',
        'quantity',
        'type',
        'packaging_type',
        'package_quantity',
        'net_weight',
        'item_price',
        'arrival_datetime',
        'departure_datetime',
        'status',
    ];

    protected $casts = [
        'packaging_list' => 'array',
        'arrival_datetime' => 'datetime',
        'departure_datetime' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'model');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'security_approved' => 'Menunggu Persetujuan Export-Import',
            'export_import_approved' => 'Menunggu Persetujuan Warehouse',
            'warehouse_approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }
}
