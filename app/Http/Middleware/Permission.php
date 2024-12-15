<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $param): Response
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else {
            $permissions = \App\Models\Permission::where('role_id', auth()->user()->role)
            ->whereIn('route_name', explode('|', $param))
            ->get()
            ->count();

            if(!$permissions){
                abort(401);
            }
        }
        return $next($request);
    }
}
