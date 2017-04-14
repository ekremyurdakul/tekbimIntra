<?php

namespace App\Http\Middleware;

use App\Authorisation;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkPriv
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
        $currentUser = Auth::user();

        if($currentUser != null){
            $privs = Authorisation::where('user_id',$currentUser->id)->get();

            if(sizeof($privs) != 0)
            foreach($privs as $priv){

                if($request->is($priv->module()->get()[0]->link) or $request->is($priv->module()->get()[0]->link . '/'.'*')){

                    if (strpos($request->url(),'aedit') !== false ){

                        if ($priv->authorisation()->get()[0]->id == 1){
                            return $next($request);
                        }else{
                            abort(403, 'Unauthorized action.');

                            return null;
                        }

                    }
                    return $next($request);

                }


            }

        }else{
            return redirect('/home');
        }

        abort(403, 'Unauthorized action.');
        
        return null;
    }
}
