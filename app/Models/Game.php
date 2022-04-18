<?php

namespace App\Models;

use App\Models\Concerns\HasClips;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory, HasClips;

    protected $fillable = [
        'tracking_id',
        'name',
        'slug',
        'box_art_url',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
