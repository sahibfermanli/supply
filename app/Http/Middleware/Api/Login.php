<?php

namespace App\Http\Middleware\Api;

use App\ApiUsers;
use App\Http\Resources\Messages as MessagesResource;
use App\Http\Resources\Users as UserResource;
use Closure;
use Illuminate\Support\Facades\Request;

class Login
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
        try {
            $username = Request::header('username');
            $password = Request::header('password');

            if (ApiUsers::where(['username'=>$username, 'password'=>$password, 'deleted'=>0])->count() > 0) {
                return $next($request);
            }

            return redirect('/api/404');
        } catch (\Exception $e) {
            return redirect('api/message');
        }
    }
}
