<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Session;

class CheckUser
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
        // return $next($request);
        // $data = Session::get('userdata');
        // if (!empty($data) && $data['data']['role_id'] != '1') {
        //     return $next($request);
        // }
        if (auth()->user() && auth()->user()->role_id != '1') {
            return $next($request);
        }
        // return redirect('/login');
        return redirect('/admin/dashboard');
        // return response()->json('You are not allowed!');
    }
}
