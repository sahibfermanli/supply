<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Categories;
use App\Purchase;
use App\Alternatives;
use Illuminate\Support\Facades\View;

class Director
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
        if (Auth::user()->authority() == 5) {
          return $next($request);
        }
        return redirect('/');
    }
}
