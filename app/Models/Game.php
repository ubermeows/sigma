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

    protected $hidden = ['created_at', 'updated_at'];

    public function clips()
    {
        return $this->hasMany(Clip::class);
    }

    public function activeClips()
    {
        return $this
            ->clips()
            ->where('state', ClipStates::Active);
    }
}
