<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AccessRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_code',
        'user_id',
        'user_name',
        'user_email',
        'requested_source',
        'preferred_date',
        'purpose',
        'estimated_volume',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'submitted_at' => 'datetime',
    ];

    /**
     * Access request owner.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Associated schedule.
     */
    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }
}
