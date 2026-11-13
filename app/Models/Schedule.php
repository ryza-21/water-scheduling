<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_request_id',
        'schedule_date',
        'time_slot',
        'status',
    ];

    // <--- I-add kini aron mahimong Carbon date object ang schedule_date
    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function accessRequest()
    {
        return $this->belongsTo(AccessRequest::class);
    }
}