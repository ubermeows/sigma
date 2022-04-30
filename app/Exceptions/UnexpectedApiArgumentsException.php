<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Log\Logger;
use Illuminate\Support\MessageBag;

class UnexpectedApiArgumentsException extends Exception
{
    public function __construct(
        protected MessageBag $messageBag,
    ){}

    public function report()
    {
        app(Logger::class)
            ->channel('api')
            ->error([
                request()->getRequestUri(),
                $this->messageBag->toJson(),
            ]);
    }

    public function render()
    {
        return response()->json([
            'message' => 'Unexpected api arguments.',
            'request-id' => request()->header('Request-Id'),
        ], 404);
    }
}
