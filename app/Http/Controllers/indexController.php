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
    public function __construct()
    {
        $this->middleware('MustBeLoggedIn');
    }
    /**
    *
    *	return index page
    *	@return view
    */
    public function index()
    {
        return view('pages.index');
    }
}
