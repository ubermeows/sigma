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
            'message' => "I'm sorry Dave, I'm afraid I can't do that.",
            'request-id' => request()->header('Request-Id'),
        ], 404);
    }
}
