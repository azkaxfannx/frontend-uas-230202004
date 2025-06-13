<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('logged_in')) {
            return redirect('/login')->with('error', 'Silakan login dulu.');
        }
        return $next($request);
    }
}