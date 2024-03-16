<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CustomMiddleware
{
    public function handle($request, Closure $next)
{
    $user = User::with('roles')->where('id',Auth::id())->first();
    if(count($user->roles)){
        foreach($user->roles as $role){
            if($role->name == "user"){
                return redirect('/');
            }
        }
    }
    
    return $next($request);
}

}
