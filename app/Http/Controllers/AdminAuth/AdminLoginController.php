<?php



namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Validator;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hesto\MultiAuth\Traits\LogsoutGuard;


class AdminLoginController extends Controller
{

   
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/admin'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        
        
        $this->middleware('guest:admin' , ['except' => ['logout'] ]);
        $this->middleware(['web', 'user', 'auth:admin']) ->only('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
     public function showLoginForm()
     {

                     $admin = DB::table('admins')->get();  

                     if(count($admin) == 0){
                        return view('admin.auth.create_admin');
                     }
                     else{
                        return view('admin.auth.admin-login');
                     }
 
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
   

    public function create(Request $request){
            
     $validator = Validator::make($request->all(),[
         'username' => 'required|min:6|alpha',
         'password' => 'required|min:6'
        ]);

      if($validator->fails()){

    return redirect()->back()->withInput($request->only('username'))->withErrors($validator);
      }

            $admin = new Admin;
            $admin->name=Input::get('username');
            $admin->password=Hash::make(Input::get('password'));
            $admin->save();
            return redirect()->route('admin.dashboard');
     }

     public function login(Request $request){
      
        // Validation des informations
      $validator = Validator::make($request->all(),[
         'username' => 'required|exists:admins,name',
         'password' => 'required'
        ]);

      if($validator->fails()){

        return redirect()->back()->withInput($request->only('username'))->withErrors($validator);
      }
        

        // Attente d'authentification 
        if(Auth::guard('admin')->attempt(['name' => $request->username, 'password' => $request->password])){
         // Si c'est réussi, redirection vers le dashboard
           return redirect()->intended(route('admin.dashboard'));
        }        
         // sinon redirection vers le login
           return redirect()->back()->withInput($request->only('username'))->withErrors(['password' => 'Mot de passe incorrect']);
    }


     protected function guard()
    {
       
        return Auth::guard('admin');
    }

    

   
}

