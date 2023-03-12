<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
    //to get jwt token from cookies
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->cookie('jwt');//getting token from cookies
        if($token){
            // set token in headers autherization and this way is more secure
            $request->headers->set('Authorization',"Bearer ".$token);
        }
        $this->authenticate($request , $guards);
        return $next($request);
    }

}
