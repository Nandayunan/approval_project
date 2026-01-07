<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilmForm extends Model
{
    protected $fillable = [
        'user_id',
        'awb_number',
        'invoice_number',
        'packaging_list',
        'manifest_entry',
        'noa_number',
        'status',
    ];

    protected $casts = [
        'packaging_list' => 'array',
        'manifest_entry' => 'array',
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
            'submitted' => 'Menunggu Persetujuan Keamanan',
            'security_approved' => 'Menunggu Persetujuan Export-Import',
            'export_import_approved' => 'Menunggu Persetujuan Warehouse',
            'warehouse_approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }
}
