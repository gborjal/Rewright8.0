<?php

namespace App\Http\Controllers;

use App\Models\User;
use \Validator;
use \Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Http\Response;



class AuthController extends Controller
{
    /**
     * Redirect to route Path after login
     *
     * @var string
     */
    protected $redirectTo = "dashboard";
    /*
     * Create a AuthController Instance
     *
     *
     */
    public function __construct()
    {
        $this->middleware('guest',['except' => 'getLogout']);
    }
    /**
     * Go to get Admin login.
     *
     * 
     * @return view 
     */
    public function showAdminLoginForm()
    {
        //return redirect()->route('loginAdminForm');
        return view('default.loginAdmin'); 
    }
    /**
     * Create a new authentication controller instance.
     *
     * @return error
     * @return view 
     */
    public function loginAdmin(Request $request)
    {
        
        // create our user data for the authentication
        $userdata =  $request->only([
            'login_id',
            'password'
        ]);
        
        $remember = $request->input('remember');
        
        $field = filter_var($userdata['login_id'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if($field == 'email') {
            $rules = array(
                'email' => 'required|email|max:255', // make sure the email is an actual email
                'password' => 'required|string|min:6' 
            );
        }else{
            $rules = array(
                'username' => 'required|string|max:255', // make sure the username exists
                'password' => 'required|string|min:6' 
            );    
        }
        
        // change login_id key to appropriate key
        if (key_exists('login_id',$userdata)) {
            if($field == 'email'){
                $userdata['email'] = $userdata['login_id'];
                unset($userdata['login_id']); 
            }else{
                $userdata['username'] = $userdata['login_id'];
                unset($userdata['login_id']); 
            }
            $userdata['user_types'] = 0;
        }

        // run the validation rules on the inputs from the form
        $validator = Validator::make($userdata, $rules);
        
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->except(['password']));
        }else {
            //var_dump($userdata);
            if(Auth::attempt($userdata,$remember)){
                if($field == 'email'){
                    $user = User::where('email','=',$userdata['email'])->first();
                    
                }else{
                    $user = User::where('username','=',$userdata['username'])->first();
                }
                $tokenResult = $user->createToken('authToken')->plainTextToken;

                return redirect()->route('dashboardAdmin')
                        ->with('authToken',$tokenResult);
                        
            }else{               
                if($field === "email"){
                    if(DB::table('users')->where('email','=',$userdata['email'])->count() === 0){
                        return redirect()->route('showLoginForm')
                            ->with('error','Account does not exist.')
                            ->withInput($request->except('password'));
                    }else{
                        $db = DB::table('users')->select('user_types')->where('email','=',$userdata['email'])->first();
                        
                        $err_type = -1;
                        foreach($db as $acc){
                            if($acc->user_types != '0'){
                                $err_type = 0;
                                break;
                            }
                        }
                        if($err_type == 0){
                            return redirect()->route('loginAdmin')
                                    ->with('error','Account does not have the proper privileges.')
                                    ->withInput($request->except('password'));
                        }else{
                            return redirect()->route('loginAdmin')
                                ->with('error','E-mail and Password does not match.')
                                ->withInput($request->except('password'));
                        }
                    }
                }else{
                    if(DB::table('users')->where('username','=',$userdata['username'])->count() === 0){
                        return redirect()->route('loginAdmin')
                        ->with('error','Account does not exist.')
                        ->withInput($request->except('password'));
                    }else{
                        $db = DB::table('users')->select('user_types')->where('username','=',$userdata['username'])->get();

                        $err_type = -1;
                        foreach($db as $acc){
                            if($acc->user_types != '0'){
                                $err_type = 0;
                                break;
                            }
                        }
                        if($err_type == 0){
                            return redirect()->route('loginAdmin')
                                    ->with('error','Account does not have the proper privileges.')
                                    ->withInput($request->except('password'));
                        }else{
                            return redirect()->route('loginAdmin')
                                ->with('error','E-mail and Password does not match.')
                                ->withInput($request->except('password'));
                        }
                    }
                }
            }
        }
    }
    /**
     * Go to get Physician/Patient login.
     *
     * 
     * @return view 
     */
    public function showLoginForm()
    {
        return view('default.login');
    }
    /**
     * Create a new authentication controller instance.
     *
     * @return error
     * @return view 
     */
    public function login(Request $request)
    {
        // var_dump($request);   
        // create our user data for the authentication
        $userdata =  $request->only([
            'login_id',
            'password'
        ]);
        $remember = $request->input('remember');
        
        $field = filter_var($userdata['login_id'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if($field == 'email') {
            $rules = array(
                'email' => 'required|email|max:255', // make sure the email is an actual email
                'password' => 'required|string|min:6' 
            );
        }else{
            $rules = array(
                'username' => 'required|string|max:255', // make sure the username exists
                'password' => 'required|string|min:6' 
            );    
        }
        
        // change login_id key to appropriate key
        if (key_exists('login_id',$userdata)) {
            if($field == 'email'){
                $userdata['email'] = $userdata['login_id'];
                unset($userdata['login_id']); 
            }else{
                $userdata['username'] = $userdata['login_id'];
                unset($userdata['login_id']); 
            }
        }

        // run the validation rules on the inputs from the form
        $validator = Validator::make($userdata, $rules);
        
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput($request->except(['password']));
        }else {
            if(Auth::attempt($userdata,$remember))
            {
                //return redirect()->route('dashboard');
                //
                if($field == 'email'){
                    $user = User::where('email','=',$userdata['email'])->first();
                    
                }else{
                    $user = User::where('username','=',$userdata['username'])->first();
                }
                $tokenResult = $user->createToken('authToken')->plainTextToken;

                return redirect()->route('dashboard')
                    ->with('project',Auth::user()->projects->first()->project_id)
                    ->with('authToken',$tokenResult);
            }else{                
                if($field === "email"){
                    if(DB::table('users')->where('email','=',$userdata['email'])->count() === 0){
                        return back()
                            ->with('error','Account does not exist.')
                            ->withInput($request->except('password'));
                    }
                    return back()
                        ->with('error','E-mail and Password does not match.')
                        ->withInput($request->except('password'));
                }else{
                    if(DB::table('users')->where('username','=',$userdata['username'])->count() === 0){
                        return back()
                            ->with('error','Account does not exist.')
                            ->withInput($request->except('password'));
                    }
                    return back()
                        ->with('error','Username and Password does not match.')
                        ->withInput($request->except('password'));
                }
            }
        }
        return back()
                ->withInput($request->except('password'));
    }

    /**
     * Return re
     *
     * @return error
     * @return view 
     */
    public function showRegistrationForm()
    {
        return view('default.register');
    }

     /**
     * Create a new user.
     *
     * @return error
     * @return view 
     */
    public function register(Request $request)
    {
        $input = $request->only([
            '_token',
            'email',
            'password',
            'user_types'
            ]);
        $rules = array(
            'email'     => 'required|email|max:255', // make sure the email is an actual email
            'password'  => 'required|string|min:6',
            'user_types' => 'required|integer',
        );

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->to('/auth/register')
                    ->withErrors($validator)
                    ->withInput($request->except(['password']));                    
        } else {

            unset($input['_token']);
            $pword = $input['password'];
            $input['password']= Hash::make($input['password']);

            if(!User::create($input)){
                return redirect()->to('/auth/register')
                    ->withErrors('Email already exists.');
            }else{
                if(Auth::attempt(['email'=>$input['email'],'password'=>$pword]))
                {
                    return redirect()->route('dashboard');//$this->redirectTo);
                }
                
                return redirect()->route($this->redirectTo)
                    ->withErrors("An error occured.");
            }
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
