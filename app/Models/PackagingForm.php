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
        'po_number',
        'invoice_number',
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

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->po_invoice_number)) {
                $po = $model->po_number ?? '';
                $inv = $model->invoice_number ?? '';
                $combined = trim($po . (!empty($inv) ? ' / ' . $inv : ''));
                $model->po_invoice_number = $combined !== '' ? $combined : '';
            }
        });
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
