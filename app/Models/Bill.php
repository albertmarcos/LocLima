<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Bill extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'description',
        'before',
        'current',
        'value',
        'paid_value',
        'discount',
        'interest',
        'fine',
        'status',
        'contract_id',
        'type',
        'due_date',
        'payment_date',
    ];

    /**
     * Get the contract associated with the bill.
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    /**
     * Get all of the bill's tasks.
     */
    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'related');
    }
}
