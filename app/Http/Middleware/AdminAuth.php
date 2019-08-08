<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuth
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
        #dd($request->user());
        if($request->user()){
            if ($request->user()->email != config('admin.email')) {
                return new Response(view('unauthorized')->with('role', 'ADMIN'));
            } else{
                return $next($request);
            }
        }else{
            return new Response(view('unauthorized')->with('role', 'ADMIN'));
        }

    }
}
