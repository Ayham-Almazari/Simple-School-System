<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if($request->is('api/*'))
        throw new HttpResponseException(
            response()->make(["message"=> "Unauthenticated."],\Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN)
        );
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
