<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MyAppMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        out("___________________ INTERCEPT _________________");
        out("URL:", $request->url()); // Without Query String...
        if(!$this->endWithVals($request->url(), "account/login" , "account/logout")){
            out("SET LATEST URI TO: ", $request->url());
            $request->session()->put("latest_request_url", $request->url());
        }
        

        return $next($request);
    }

    function endWithVals($haystack, string ...$needle){
         
        for ($i=0; $i < sizeof($needle); $i++) { 
            if($this->endsWith($haystack, $needle[$i])){
                return true;
            } 
        }

        return false;
    }

    function endsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
}