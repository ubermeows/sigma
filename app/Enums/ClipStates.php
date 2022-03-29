<?php

namespace App\Enums;

enum ClipStates : string 
{
    case Active = 'active';
    case Dead = 'dead';
    case Reject = 'reject';
}
