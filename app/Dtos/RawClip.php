<?php

namespace App\Dtos;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class RawClip extends DataTransferObject
{
    #[MapFrom('id')]
    public $id;

    #[MapFrom('url')]
    public $url;

    #[MapFrom('creator_id')]
    public $creatorId;

    #[MapFrom('creator_name')]
    public $creatorName;

    #[MapFrom('game_id')]
    public $gameId;

    #[MapFrom('title')]
    public $title;

    #[MapFrom('view_count')]
    public $viewCount;

    #[MapFrom('created_at')]
    public $createdAt;

    #[MapFrom('thumbnail_url')]
    public $thumbnailUrl;

    #[MapFrom('duration')]
    public $duration;
}
