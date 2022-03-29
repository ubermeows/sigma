<?php

namespace App\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class BearerToken extends DataTransferObject
{
    public string $value;
    public ?int $expiresIn = null;
}
