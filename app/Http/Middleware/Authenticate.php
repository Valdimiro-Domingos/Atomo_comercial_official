<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;



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
    
        $response = ($request);
        if ($response instanceof Response) {
            if ($response->getStatusCode() == 419) {
                return redirect('logout');
            }
        }

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
