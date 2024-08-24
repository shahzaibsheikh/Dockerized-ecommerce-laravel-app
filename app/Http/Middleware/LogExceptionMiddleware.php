<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Log;

class LogExceptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
public function handle(Request $request, Closure $next)
{
    try {
        return $next($request);
    } catch (\Throwable $exception) {
        // Log the exception to a custom logging channel
        Log::channel('database')->error('Adding exception in the database ',[
            'request' => $request,
            'ex'      => $exception,
        ]);

        throw $exception;
    }
 }
}
