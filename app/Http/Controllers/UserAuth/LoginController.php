<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use App\http\traits\limit_text_Trait ;
use App\http\traits\DeadLine_Trait ;
use Illuminate\Http\Request;
use App\Post;
use App\Specialite;
use App\Student;
use App\User;
use App\Representant;

class LoginController extends Controller
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
    use limit_text_Trait , DeadLine_Trait  ;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/user/home';
    public $guard ; 

    public function redirectTo() // more priority  BROTHER !
    {
        
         return '/'.$this->guard .'/home' ;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        
        $this->guard  = (pathinfo($request->path() , 1 ) );
        $this->middleware('guest:'.$this->guard , ['except' => ['logout' , 'showHome'] ]);
        $this->middleware(['web', 'user', 'auth:'.$this->guard]) ->only('showHome');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
       
        return view('Login_signup.'.$this->guard);
    }

    public function showHome(Request $request ,$person)
    {
        if($person == 'student' && Auth::user()->userable->AcceptedPost )
        {
          $student = Auth::user()->userable ;
          $Binome = Auth::user()->userable->Binome ;
          $str = ($Binome) ? ' Vous êtes en ce moment en binôme avec '.$Binome->Nom.' '.$Binome->Prenom : 
                             ' Vous êtes en ce moment Monôme' ;
           $promoteur = ( $student->promoteur_interne ) ? $student->promoteur_interne->Nom.' '. $student->promoteur_interne->Prenom  :  $student->promoteur_externe->Nom.' '.$student->promoteur_externe->Prenom.' appartenant à '.$student->promoteur_externe->Company->Raison_sociale ;
          $str = $str.'<br>Encadré par : '.$promoteur.'<br>Votre sujet est :<b>'.$student->AcceptedPost->Titre.'</b>' .'<br> VOUS POUVEZ COMMENCER A TRAVAILLER'; 
          return view ('errors.MentoredStudent' , [ 'msg' => $str ]) ;
        }
        $view = $this->DeadlineCheck('Candidature') ;
        
        if ( !$view  )
        {
        // to get specialites  for  advanced Search  in the User Home      
        $specialites['Licence'] =Specialite::select('spec')->where('niveau','Licence')->get();
        $specialites['Master'] =Specialite::select('spec')->where('niveau','Master')->get();

        
        
        //preparing   the logged in User
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard($this->guard)->user();

        
        //  if a student  ->  show    Teachers & Companies Subjects
        //  else          ->  show    Student Subjects

            $postTypesArray =  ($person == 'student') ? ['Teacher','Company'] : ['Student'] ;

        
            $posts = Post::whereHas('poster', 
                function ($query) use($postTypesArray)
             {
                        $query->whereIn('userable_type' ,$postTypesArray ) ;

             }
                    );
            
            
            
            switch ($person)

            /* for teacher (respectively company)  getting  all students posts that are En candidature  
               or   are Mentored  by the authenticated teacher (respectively company) */

            {
              case 'student':
                $posts = $posts->where('Etat','En candidature') ;
                break;
              case 'teacher': $posts = $posts->where('Etat','En candidature')
                                             ->orWhere(function ($query)
                                             {
                                                      $query->where('Etat','Affecté')->whereHas('Poster',
                                                      function($query)
                                                      {

                                                        // the returned  array is containing all Students->User->id 
                                                        $query->whereIn('userable_id' , Student::where( 
                                                        'promoteur_interne_id' , Auth::user()->userable->id )->pluck('id')->toArray()) ;
                                                      })  ;  

                                                      
                                             }) ;
                                            
                            

                break;
              case 'company': $posts = $posts->where('Etat','En candidature')
                                             ->orWhere(function ($query)
                                             {
                                                      $query->where('Etat','Affecté')->whereHas('Poster',
                                                      function($query)
                                                      {

                                                        // the returned  array is containing all Students->User->id 
                                                        $query->whereIn('userable_id' , Student::where( 
                                                        'promoteur_externe_id' , Auth::user()->userable->id )->pluck('id')->toArray()) ;
                                                      })  ;  

                                                      
                                             }) ;
                                             

                                          

                break;
            }
        

            $posts = $posts->withCount('comments')->with('poster')->get();  



        
        /*Preparing  the post   with  its       Limited Text showed  ( 260 words)
            its  Photo  and Finally  Date Formats     */

        $i=0 ; 
        foreach ($posts as $post)
        {
                  //limit words
                  $posts[$i]->Resume = $this->limit_text($post->Resume , 260 ) ;
                  //  Post  photo 
                  $bool = !empty(glob('storage/Postimages/'.$post->id.'*.jpg')) ; 
                  $posts[$i]->imagePath =  $bool  ?   glob('storage/Postimages/'.$post->id.'*.jpg')[0]    : "" ; 
                  //DateTime Format
                  setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //French
                  $posts[$i]->created = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->created_at) )   ;
                  $posts[$i]->updated = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->updated_at) )    ;

                  

                  
                  
                  //Logic  to load  button  Postulé déja & Encadré deja  
                  if(
                       (
                          $person == 'student' && Auth::user()->userable->requestedPosts->contains($post->id)
                       )

                       ||

                       (
                          $person == 'teacher' && !is_null($post->poster->userable->promoteur_interne) && 
                          // determine if the current teacher is Promoteur interne of the post
                          Auth::user()->userable->id == $post->poster->userable->promoteur_interne->id
                       ) 

                       ||

                       (
                         $person == 'company' && !is_null($post->poster->userable->promoteur_externe) && 
                         // determine if the current Company has a 'Representant' which is promoteur externe
                         // of this post
                          Auth::user()->userable->Representants->contains($post->poster->userable->promoteur_externe) 
                       )

                    )
                 

                        {
                          $posts[$i]->activate = true ;
                        }
                        else
                        {
                          $posts[$i]->activate = false ;
                        }
                  
                  
                  $i++ ;
                                  
        }

        
        if($person == 'company')
        {
         $Employes = array() ;
         $Employes =  Auth::user()->userable->Representants ;
        }

      
       
        return view('user.Pages.UserHome' , ['specialites' => $specialites , 'posts' => $posts,
                                                    'type' => $this->guard ,'employes' => Auth::user()->userable->Representants  ]);

        }
        else
        {
          $view['data']['msg'] ='Vous devez patienter pour une période ultérieure déstinée aux candidatures'  ;
          return view($view['page'] , $view['data'] ) ;
        }

       
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
       
        return Auth::guard($this->guard );
    }

    protected function credentials(Request $request)
    {
        $credentials= $request->only('password');
        $credentials['is_Activated'] = 1 ; 
        $credentials['is_Approved' ] = 1 ; 
        $credentials['userable_type'] = $this->guard ; 
        $userlogin = filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials[$userlogin] = request('email') ;
         /* the input is called email however  the content it can be email or username*/

        return $credentials ;
    }

   
}
