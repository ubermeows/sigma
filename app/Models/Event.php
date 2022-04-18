<?php

namespace App\Models;

use App\Models\Concerns\HasClips;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, HasClips;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
