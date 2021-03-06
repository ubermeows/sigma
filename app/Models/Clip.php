<?php

namespace App\Models;

use App\Enums\ClipStates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clip extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'state',
        'creator_id',
        'game_id',
        'url',
        'title',
        'thumbnail_url',
        'duration',
        'views',
        'freshed_at',
        'published_at',
    ];

    protected $hidden = ['freshed_at', 'created_at', 'updated_at'];

    protected $casts = [
        'state' => ClipStates::class,
    ];

    protected $dates = [
        'freshed_at',
        'published_at',
    ];

    public function creator()
    {
        return $this->belongsTo(Creator::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeActive($query)
    {
        return $query->where('state', ClipStates::Active);
    }
}
