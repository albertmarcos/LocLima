<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'last_name',
        'surname',
        'description',
        'phone',
        'address',
        'user_id',
        'location_id',
        'type',
        'cpf',
        'rg',
        'email',
        'birthdate',
        'gender',
        'nationality',
        'profile_photo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'peoples_id');
    }

    public function bills(): HasManyThrough
    {
        return $this->hasManyThrough(Bill::class, Contract::class, 'peoples_id', 'contract_id', 'id', 'id');
    }
}
