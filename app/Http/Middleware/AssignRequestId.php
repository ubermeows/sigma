<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Log\Logger;
use Illuminate\Support\Str;
 
class AssignRequestId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestId = (string) Str::uuid();
 
        app(Logger::class)
            ->channel('api')
            ->withContext([
                'request-id' => $requestId,
            ]);

        $request->headers->set('Request-Id', $requestId);

        return $next($request);
    }
}
