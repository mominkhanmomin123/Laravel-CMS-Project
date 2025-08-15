<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){//ye handle function user ki sari request ko handle krta hai. or ye function ek response return karega or is response me url return karega jis par user ko bhejna hai. is function k andar hi ham apni condition pass krte hn. matlab ham is middleware me kia kaam krna chahte hn. jese ham ne pichli authentication ki video me dekha tha k ham user ko login or logout karwate hn to uske liye check method ka use krte hn. same authentication ham is middleware me pass krte hn
        //echo "<h1>we are in middle ware ValidUser</h1>";//ab ham is "validUser" class ko kisi route k sath middleware me pass krenge to us page me ye heading bhi ayegi 
        return $next($request);
        }else{
            return redirect()->route('guestuser');
        }
    }
}
