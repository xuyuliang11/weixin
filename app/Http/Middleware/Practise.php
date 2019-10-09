<?php

namespace App\Http\Middleware;

use Closure;

class Practise
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
        $openid=request()->session()->get('openid');
        if(!$openid){
            return redirect('practise/login');
        }
        return $next($request);
    }
}
