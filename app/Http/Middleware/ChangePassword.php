<?php

namespace App\Http\Middleware;

use App\Vendor;
use Closure;

class ChangePassword
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
        if(auth()->check()){
            if(auth()->user()->change_password==1 || $request->path() == 'profile' || $request->path() == 'profile/password' || $request->route() == 'profile.password' || $request->method() == 'PUT' || $request->method() == 'put')
            {
                return $next($request);
            }else{
                return redirect('profile')->withStatus(__('Welcome, please change your password.'));
            }
        }else{
            return redirect("/login");
        }
    }
}