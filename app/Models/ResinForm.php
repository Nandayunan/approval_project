<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ResinForm extends Model
{
    protected $fillable = [
        'user_id',
        'supplier_name',
        'npwp_number',
        'po_number',
        'invoice_number',
        'vehicle_registration_number',
        'packaging_list',
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
        'total_packages' => 'integer',
        'total_types' => 'integer',
        'gross_weight' => 'float',
        'quantity' => 'integer',
        'package_quantity' => 'integer',
        'net_weight' => 'float',
        'item_price' => 'float',
        'arrival_datetime' => 'datetime',
        'departure_datetime' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'model');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'menunggu_persetujuan_export_import' => 'Menunggu Persetujuan Export-Import',
            'menunggu_persetujuan_warehouse' => 'Menunggu Persetujuan Warehouse',
            'menunggu_persetujuan_security' => 'Menunggu Persetujuan Security',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }
}
