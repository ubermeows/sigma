<?php

namespace App\Enums;

enum ClipStates : string 
{
    case Active = 'active';
    case Suspect = 'suspect';
    case Reject = 'reject';
    case Dead = 'dead';
}
