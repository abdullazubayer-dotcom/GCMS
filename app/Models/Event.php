<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'event_date',
        'start_time',
        'end_time',
        'venue',
        'description',
        'event_fee',
        'capacity',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_fee' => 'decimal:2',
        'capacity' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
