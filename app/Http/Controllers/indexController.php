<?php

namespace App\Http\Controllers;

use App\Models\User;
use \DB;
use \Session;
use \Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

class indexController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('MustBeLoggedIn');
    }*/
    /**
    *
    *	return index page
    *	@return view
    */
    public function index()
    {
        if(!is_null(Auth::user())){
            if(Auth::user()->user_types === 0) {
                return redirect()->route('dashboardAdmin');
            }else{
                return redirect()->route('dashboard');
            }
        }
        return view('pages.index');
    }
    /**
    *
    *   return registration page
    *   @return view
    */
    public function registerByNormal()
    {
        if(!is_null(Auth::user())){
            if(Auth::user()->user_types === 0) {
                return redirect()->route('dashboardAdmin');
            }else{
                return redirect()->route('dashboard');
            }
        }
        return view('default.register');
    }
}
