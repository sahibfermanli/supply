<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Categories;
use App\Orders;
use App\Purchase;
use Illuminate\Support\Facades\View;

class Supply
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
        if (Auth::user()->authority() == 4) {
          return $next($request);
        }
        return redirect('/');
    }
}
