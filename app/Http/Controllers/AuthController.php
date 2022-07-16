<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\project;
use App\Models\developer;

use \Validator;
use \Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Registered;



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
                //$tokenResult = $user->createToken('authToken')->plainTextToken;

                return redirect()->route('dashboardAdmin');
                        //->with('authToken',$tokenResult);
                        
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
                            if($acc->user_types != 0){
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
                /*if($field == 'email'){
                    $user = User::where('email','=',$userdata['email'])->first();
                    
                }else{
                    $user = User::where('username','=',$userdata['username'])->first();
                }
                $tokenResult = $user->createToken('authToken')->plainTextToken;*/
                
                if(Auth::user()->user_types !== 0 && (is_null(Auth::user()->userInformation))){
                    $prompt = "";
                    if(Auth::user()->user_types === 1) {
                        $prompt = 'User Information unaccomplished. Please contact admin.';
                        return redirect('/auth/profile/edit/' . Auth::user()->activation_code)
                                ->with('error',$prompt);
                    }else if(Auth::user()->user_types === 2){
                        $prompt = 'User Information unaccomplished. Please contact your physician.';
                    }
                    Auth::guard('web')->logout();
                    return back()
                        ->with('error',$prompt)
                        ->withInput($request->except('password'));
                }
                
                return redirect()->route('dashboard')
                    ->with('project',Auth::user()->projects->first()->project_id);
                    //->with('authToken',$tokenResult);
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
     * Create a new user.
     *
     *  note: might want to change function name down the line
     *
     * @return error
     * @return view 
     */
    public function registerByNormal(Request $request)
    {  
        $response = [
            'status'       => "",
            'message'      => []
        ];
        $input = $request->only([
                    '_token',
                    'email',
                    'user_types',
                    'password'
                    ]);
        $input['user_types'] = 1;    // only physicians can register here
        $rules = array(
            'email'     => 'required|email|max:255' // make sure the email is an actual email
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {//change to /admin/dashboard
            $response['status'] = 'validatorFail';
            $response['message'] = $validator->errors();
            
            return response()
                ->json($response)
                ->setCallback($request->input('callback'));
        } else {
            unset($input['_token']);
            $pword = AuthController::unique_code(8);
            
            $input['password']= Hash::make($input['password'];//Hash::make($pword);
            $input['username'] = explode("@", $input['email'])[0];
            $input['activation_code'] = $pword;
            $input['user_types'] = 1; //physician only
            //search for existing
            
            $query = User::where('email','=',$input['email'])
                    ->get();
            
            
            if(is_null($query) || count($query) == 0){
                
                $user = DB::table('users')
                            -> insertGetId($input);
                $proj_id = project::insertGetId([
                             'owner_id' => $user,
                             'text' => $input['username'],
                             'size' => 10,
                             'active' => true
                            ]);
               
                $admin_grp = developer::insert([ 
                                        'project_id'    => User::where('email','=','gborjal01@gmail.com')
                                                            ->first()->projects[0]->project_id,
                                        'user_id'       => $user,
                                        'role'          => $input['user_types']
                                        ]);
                $dev_inp = developer::insert([ 
                                        'project_id'    => $proj_id,
                                        'user_id'       => $user,
                                        'role'          => $input['user_types']
                                        ]);
                
                $newUser = User::where('email','=',$input['email'])
                            ->first();
                event(new Registered($newUser));     //will send the verification email             
                
                $response['status'] = 'success';
                $response['message'] = $pword;

                return redirect()->route('verification.notice');
            }else{
                $response['status'] = 'fail';
                $response['message'] = 'Email already exists.';
                return response()
                    ->json($response);
            }
        }
             
        
    }
    /**
     * Verification Notice.
     *
     *  note: Notice after registration
     *
     * 
     * @return view 
     */
    public function verificationNotice(Request $request)
    {  
        return view('auth.verify-email');
    }
    /**
     * Verification Verified.
     *
     *  note: User is Verified
     *
     * 
     * @return view 
     */
    public function verificationVerified(EmailVerificationRequest $request)
    {  
        $request->fulfill();
 
        return view('auth.verified-user');
    }
    /**
     * Verification Email resend.
     *
     *  note: Resending of verification email
     *
     * 
     * @return view 
     */
    public function verificationResend(Request $request)
    {  
        $request->user()->sendEmailVerificationNotification();
 
        return back()->with('error', 'Verification link sent!');
    }
    /**
     *  return unique code
     *
     *  source: https://codebriefly.com/unique-alphanumeric-string-php/
     *  @return /code
     */
    private function unique_code($limit)
    {
      return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
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
