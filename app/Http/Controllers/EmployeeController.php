<?php

namespace App\Http\Controllers;

use App\Authorisation;
use App\AuthorisationType;
use App\Module;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('authCheck');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $modules = Module::all();
        $authorisationTypes = AuthorisationType::all();
        return view('employee')->with([
            'users' => $users,
            'modules' => $modules,
            'authorisationtypes' => $authorisationTypes,
        ]);
    }
    public function edit(Request $request)
    {
       $userId = $request->id;
        Authorisation::where('user_id',$userId)->delete();

        foreach ($request->all() as $module => $auth){

            if(is_numeric($module)){

                if(is_numeric($auth)){
                    Authorisation::create([
                        'user_id' => $userId,
                        'module_id' => $module,
                        'authorisation_type_id'=>$auth,
                    ]);
                }

            }
        }

        return back();
    }


}
