<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Publish
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$guard = null)
    {

        if (Auth::guard($guard)->check()) {
           $plan= DB::table('payments')->where('user_id',Auth::user()->id)->first();
           $wallet_check= DB::table('users')->where('id',Auth::user()->id)->first();
            if(!$plan){ 
                       return redirect('/dashboard')->withErrors('You cannot publish without adding payment method.');
                }
                else
                { 
                    if($wallet_check->is_admin==0)
                    {
                        if($wallet_check->wallet==null ||$wallet_check->wallet<=0)
                        {
                            return redirect('/dashboard')->withErrors('Your wallet is empty! make payment first.');
                        }
                    }
                }

        }

        return $next($request);
    }
}
