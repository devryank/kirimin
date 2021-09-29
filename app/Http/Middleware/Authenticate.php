<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

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
        if (!$request->expectsJson()) {
            return route('noauth');
        }
        // if (request()->user()->hasRole('seller')) {
        // }
        // if (request()->user()->hasRole('user')) {
        //     return redirect()->route('general.index');
        // }
    }
}
