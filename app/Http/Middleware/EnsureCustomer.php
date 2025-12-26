<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('role') !== 'customer') {
            return redirect('/login');
        }
        return $next($request);
    }
}
