<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('is_portfolio_admin', false)) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

