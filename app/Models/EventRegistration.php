<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRegistration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
