<?php

namespace App\Repositories\Abstracts;

use Illuminate\Http\Request;

abstract class AbstractFilter
{
    public function __construct(
        protected Request $request,
    ){}
}
