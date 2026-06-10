<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'member_code',
        'joining_date',
        'membership_type',
        'membership_status',
        'date_of_birth',
        'gender',
        'blood_group',
        'occupation',
        'organization',
        'address',
        'permanent_address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'date_of_birth' => 'date',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
