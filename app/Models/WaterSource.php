<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class WaterSource extends Model
{
    use HasFactory, SoftDeletes; 
    protected $fillable = [
        'source_id',
        'source_name',
        'location',
        'capacity',
        'status',
    ];
}