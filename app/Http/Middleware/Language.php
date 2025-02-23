<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Language
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

        if(auth()->check()){
            \App::setlocale(auth()->user()->lang_code);
        }
        elseif(\Session::has('locale')){
            $lang = \Modules\Language\Entities\Language::where('code', \Session::get('locale'))->first();
            if($lang){
                \App::setlocale(\Session::get('locale'));
            }else{
                \Session::forget('locale');
            }

        }
        elseif(\App::bound('general_setting')){
            \App::setlocale(app('general_setting')->language_code);
        }
        else{
            \App::setlocale('en');
        }
        if(!empty($request->get('lang')))
        {
            \App::setlocale($request->get('lang'));
        }
        return $next($request);
    }
}
