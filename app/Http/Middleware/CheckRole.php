<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $roles1, $roles2 = NULL, $roles3 = NULL)
    {
        $roles[] = $roles1;
        if(!empty($roles2)){ $roles[] = $roles2; }
        if(!empty($roles3)){ $roles[] = $roles3; }

        if (!Auth::user()->hasAnyRole($roles)) {
            return redirect('/home');
        }

        return $next($request);
    }

}