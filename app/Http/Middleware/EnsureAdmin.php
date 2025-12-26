<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('role') !== 'admin') {
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
