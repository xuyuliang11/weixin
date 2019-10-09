<?php

namespace App\Http\Middleware;

use Closure;

class zuoye
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
        $zuoye=request()->session()->get('zuoye');
        if(!$zuoye){
            return redirect('zuo/login');
        }
        return $next($request);
    }
}
