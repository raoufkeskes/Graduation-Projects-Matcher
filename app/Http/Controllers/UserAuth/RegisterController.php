<?php

namespace App\Http\Controllers\UserAuth;

use App\User;
use App\Student;
use App\Teacher;
use App\Company;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File ;


use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';
    protected $type ; 
    public function redirectTo()       // more priority  BROTHER !
    {
        
         return '/'.$this->$type.'/SuccessRegister' ;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->type  = (pathinfo($request->path() , 1 ) );
        $this->middleware('user.guest');
    }

    
    public function Register( Request $request  , $person )
    {

        
            
          $rules = 
            [
                    
                    'user'             => 'required|min:4|max:30|unique:user,username|regex:/^[a-zA-Z0-9-_\s]+$/',
                    'e-mail'           => 'required|email|unique:user,email|max:50' , 
                    'pass'             => 'required|min:8|max:30',
                    'password_confirm' => 'required|same:pass',
                    'telephone'        => 'digits_between:9,10|unique:user|regex:/^0[0-9]{8,9}$/' 
                    
            ] ;

            //Filling the rest of rules according to user type 
            switch ($person) 
            {
               
                case 'student':
                {
                    $rules['nom']           = 'required|max:50|regex:/^[À-ÿa-zA-Z\s]+$/' ;
                    $rules['prenom']        = 'required|max:50|regex:/^[À-ÿa-zA-Z\s]+$/' ;

                    $rules['matricule']     ='required |unique:student|digits:12' ;
                    $rules['Specialité']    ='required' ;
                    $rules['Niveau']        ='required' ;
                    

                    $data['person'] = 'Student' ; // Uses  for email link confirmation
                }
                break;
                
                case 'teacher':
                {
                   $rules['nom']           = 'required|max:50|regex:/^[À-ÿa-zA-Z\s]+$/' ;
                   $rules['prenom']        = 'required|max:50|regex:/^[À-ÿa-zA-Z\s]+$/' ;

                   $rules['grade']         =  'required' ;
                   $rules['profession']    =  'required|regex:/^[a-zA-Z-_\s]+$/' ;

                   $data['person']         = 'Teacher' ;
                }
                break ; 

                case 'company':
                {
                   
                   

                    $rules  ['raison_sociale']   =  'max:100|unique:company,raison_sociale' ;
                    $rules  ['justificatif']     =  'required|mimes:jpeg,bmp,png' ;
                    $data   ['person']           =  'Company' ;
                }
                break ;

            }



            $request->flashExcept('pass'); // to flash the old inputs 
            $this->validate(request(),$rules);

            //creating the basic user 
            $user = new User();
            $user->username  =  $request->input('user');
            $user->email     =  $request->input('e-mail');
            $user->password  =  bcrypt($request->input('pass'));
            $user->telephone =  $request->input('telephone');
            $user->token     =  str_random(25) ;

            
             

            // Creating the inherited user 
            switch ($person) 
            {
               
                case 'student':
                {
                    //make the name custom  Exemple   Amir Abdel'Kader  & not  aMir AbdeLKADER  as the user post it 
                    $str = mb_convert_case( $request->input('prenom'), MB_CASE_TITLE, "UTF-8");
                    $pos = strpos($str, "'");
                    if ($pos != FALSE)
                    {
                         $str[$pos+1] = strtoupper($str[$pos+1]);
                    }
                    //end 

                    $student = new Student();
                    $student->nom        = strtoupper($request->input('nom')) ;  
                    $student->prenom     = $str ;
                    $student->matricule  = $request->input('matricule') ;
                    $student->specialite = $request->input('Specialité') ;
                    $child = $student ;
                    // the variable $child  is named child  to refer to INHERITANCE from User 
                }
                break;
                
                case 'teacher':
                {

                    //make the name custom
                    $str = mb_convert_case( $request->input('prenom'), MB_CASE_TITLE, "UTF-8");
                    $pos = strpos($str, "'");
                    if ($pos != FALSE)
                    {
                         $str[$pos+1] = strtoupper($str[$pos+1]);
                    }
                    //end 

                    $teacher = new Teacher();
                    $teacher->nom        = strtoupper($request->input('nom')) ; 
                    $teacher->prenom     = $str ;
                    $teacher->grade      = $request->input('grade') ;
                    $teacher->profession = $request->input('profession') ;
                    $child = $teacher ; 
                }
                break ;

                case 'company':
                {

                    $company = new Company();
                    $company->Raison_sociale = $request->input('raison_sociale') ; 
                    $child = $company ;
                    

                    if ($request->hasFile('justificatif') && $request->file('justificatif')->isValid()) 
                    {
                        //delete  the existing image
                        
                        //for security
                        $token = str_random(20);

                        $path = $request->justificatif->storeAs('Users/Company/RegistreDeCommerce'
                         ,$token.'.jpg', 'public');
                        $company->registre_image = 'storage/Users/Company/RegistreDeCommerce/'.$token.'.jpg' ;
                    }
                    //END ProfilePhoto  updated !
                }
                break ;

            }
            
            //Save all of them
            $user->save();
            $child->save();
            // linking them using the polymorphic relationship
            $child->user()->save($user);

           //sending confirmation email
            $data['person'] = $this->type ;
            $data['email'] = $request->input('e-mail') ;
            $data['token'] = $user->token ;
            Mail::send('mails.confirmation', $data, function ($message) use($data)
            {
    
                $message->to($data['email']);
            
                $message->subject('Confirmation d\'inscription');

            });

              return redirect()->route('Success' , $person ) ;
           

            
    }

   
    public function confirmation ($person , $token)
    {
        $user = User::where('token',$token)->first() ;
        
        if ( ! is_null($user))
        {
            $user->is_Activated = 1 ; 
            $user->token = '' ; 
            $user->save() ;
            return  view('Login_signup.Success.EmailConfirmation') ;
        }
        return  view('Login_signup.Success.Error') ;
    }

    public function Success()
    {
         
         return view('Login_signup.Success.Register') ;
    }

}
    
