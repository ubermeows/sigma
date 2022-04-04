<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'name',
        'slug',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
