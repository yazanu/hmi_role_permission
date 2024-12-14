<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class UseApiGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        auth()->setDefaultDriver('api');

        if(Auth::check()){
            if(auth()->user()->is_active != config('status.user_status.active') && auth()->user()->role !== 'user'){
                
                abort('401', 'Unauthorized user.');
            }
        }
        return $next($request);
    }
}
