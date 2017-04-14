<?php

namespace App\Http\Controllers;

use App\Authorisation;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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
    public function register(Request $request)
    {
        Customer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'address'=>$request->address,
        ]);

        return back()->with('status', 'Başarıyla Kaydedilmiştir');
    }
    public function search($search)
    {
        $retVal = Customer::where('name','like',$search . '%')->get(['name'])->pluck('name');
        
        return json_encode($retVal);

    }

    public function emptySearch()
    {
        return json_encode(array());
    }

}
