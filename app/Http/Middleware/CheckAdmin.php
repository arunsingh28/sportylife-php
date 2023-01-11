<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
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
        $role_arr = ['1', '3', '4', '5'];

        // if (auth()->user() && in_array(auth()->user()->role_id, $role_arr)) {
        if (auth()->user() && auth()->user()->role_id != '2') {
            return $next($request);
        }
        return redirect('/admin/login');
        // return response()->json('You are not allowed!');
    }
}
