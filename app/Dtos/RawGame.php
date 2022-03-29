<?php

namespace App\Dtos;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class RawGame extends DataTransferObject
{
    #[MapFrom('id')]
    public $id;

    #[MapFrom('name')]
    public $name;

    #[MapFrom('box_art_url')]
    public $boxArtUrl;
}
