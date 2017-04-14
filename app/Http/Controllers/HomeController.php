<?php

namespace App\Http\Controllers;

use App\Authorisation;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auths = Authorisation::where('user_id',Auth::user()->id)->get();
        if (sizeof($auths) == 0){
            return view('home')->with(['authorisation'=>array() ]);
        }
        return view('home')->with(['authorisation'=>$auths]);
    }
    
}
