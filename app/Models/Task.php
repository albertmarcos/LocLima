<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'owner_id',
        'responsible_id',
        'related_id',
        'related_type',
        'done'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($task) {
            if ($task->related_type === 'Bill') {
                $task->related_type = Bill::class;
            } elseif ($task->related_type === 'Equipament') {
                $task->related_type = Equipament::class;
            }
        });
    }
}
