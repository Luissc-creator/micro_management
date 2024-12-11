<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is not authenticated
        if (session('authenticated') !== 'true' && session('homepage') !== 'true') {
            session(['homepage' => 'true', 'authenticated' => 'false']);
            logger('func auth: ' . session('authenticated') . '    homepage:  ' . session('homepage'));
            // Redirect to the login page if not authenticated
            return redirect('/home');  // This assumes you have a route named 'login'
        }
        session(['homepage' => 'false']);
        // If the user is authenticated, continue with the request
        return $next($request);
    }
}
