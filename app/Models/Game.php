<?php

namespace App\Models;

use App\Enums\ClipStates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'name',
        'slug',
        'box_art_url',
    ];

    public function activeClips()
    {
        return $this
        	->hasMany(Clip::class)
        	->where('state', ClipStates::Active);
    }
}
