<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        $response = $next($request);
        //If the status is not approved redirect to login
        if (Auth::guard($guard)->check()) {
            // if($guard!='customer' && Auth::guard($guard)->user()->verification_status != 1){
            //     // $customer_id=Auth::guard($guard)->user()->id;
            //     Auth::guard($guard)->logout();
            //     return response()->json(['error' => 'Your account verification is Pending. Please contact Administrator']);
            // }
            if (Auth::guard($guard)->user()->status != 1) {
                Auth::guard($guard)->logout();

                Session::flash('msg', 'Your account has been disabled by Administrator. Please contact Administrator');

                // response();
                return Redirect::back();
            }
        }
        return $response;
    }
}
