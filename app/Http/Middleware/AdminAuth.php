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
            $validate_admin = DB::table('users')
                                ->select('email', 'password')
                                ->where('email', $request->user()->email)
                                ->first();

            #dd($validate_admin);

            if ($validate_admin->email != config('admin.login')) {
                return new Response(view('unauthorized')->with('role', 'ADMIN'));
            } else{
                return $next($request);
            }
        }else{
            return new Response(view('unauthorized')->with('role', 'ADMIN'));
        }

    }
}
