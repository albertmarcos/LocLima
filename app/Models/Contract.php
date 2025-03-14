<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'contract_number',
        'start',
        'end',
        'year',
        'value',
        'recursive',
        'type',
        'contract_id',
        'peoples_id'
    ];

    /**
     * Get the person associated with the contract.
     */
    public function people(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'peoples_id', 'id');
    }

    /**
     * Get the equipaments associated with the contract.
     */
    public function equipaments(): HasMany
    {
        return $this->hasMany(Equipament::class, 'contract_id', 'id');
    }

    /**
     * Get the bills associated with the contract.
     */
    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class, 'contract_id', 'id');
    }
}
