<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TegraForm extends Model
{
    protected $table = 'tegra_forms';

    protected $fillable = [
        'user_id',
        'status',
        'po_number',
        'invoice_number',
        'item_name',
        'item_code',
        'quantity',
        'type',
        'packaging_type',
        'package_quantity',
        'net_weight',
        'item_price',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'package_quantity' => 'integer',
        'net_weight' => 'float',
        'item_price' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'model');
    }
}
