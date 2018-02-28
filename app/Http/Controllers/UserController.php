<?php

namespace App\Http\Controllers;

use App\User ;
use App\Student ;
use App\Teacher ;
use App\Company ;
use App\Specialite ;
use App\Post ;
use App\Annee_Universitaire ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route ;
use  Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Hash;
use App\http\traits\limit_text_Trait ;




class UserController extends Controller
{
    use limit_text_Trait ;
	 public $type ;
	 public function __construct(Request $request )
    {
        
        
        $this->type  = Route::current()->parameters()['person']  ;
        $this->middleware(['web', 'user', 'auth:'.$this->type]);
    }

    public function showProfile($person ,$id)
    {

        $user = User::find($id) ;
        $specialites['Licence'] =Specialite::select('spec')->where('niveau','Licence')->get();
        $specialites['Master'] =Specialite::select('spec')->where('niveau','Master')->get();



    	
        
        //photo   
        $path = 'storage/Users/'.$user->userable_type."/".$user->id.'/ProfileImage/*.jpg' ;
        $photoarray = glob($path) ; 
        $bool = !empty($photoarray) ; 
        $photo =  $bool  ?   $photoarray[0]    : "storage/Users/no-image.jpg" ; 
        // END PHOTO

        $Cursus = array() ;
        //For students only in the a case when the student inserted  his moyennes before 
        if($person == 'student' )
        {
            $annees = $user->userable->cursus ;
            
            
              //get his Moyenne  For each year !
              foreach ($annees as $annee) 
              {
                  $Cursus[$annee->annee] = ($annee->students->find($user->userable->id)->pivot->Moyenne) ;
              }
            

        }
        //End 

    	return view('user.'.$person.'.profile' , ['specialites' => $specialites , 'user' => $user ,
                 'type' => $person ,'photo' =>$photo  , 'Cursus' => $Cursus] ) ; 
    }

    public function updateProfile(Request $request , $person ,$id)
    {

       

       
        $rules = 
            [
                    'username'         => 'required|min:4|max:30|unique:user,username,'.$id.'|regex:/^[a-zA-Z0-9-_\s]+$/'  ,
                    'telephone'        => 'digits_between:9,10|unique:user,telephone,'.$id.'|regex:/^0[0-9]{8,9}$/'      
            ] ;

            //Filling the rest of rules according to user type 
            switch ($person) 
            {
               
                case 'student':
                {
                    $rules['nom']           ='required|max:50|regex:/^[a-zA-Z\s]+$/' ;
                    $rules['prenom']           ='required|max:50|regex:/^[a-zA-Z\s]+$/' ;
                    $rules['matricule']     ='required |unique:student,matricule,'.$id.'|digits:12' ;
                    $rules['specialite']    ='required' ;
                }
                break;
                
                case 'teacher':
                {
                   $rules['nom']               =  'required|max:50|regex:/^[a-zA-Z\s]+$/' ;
                   $rules['prenom']           =  'required|max:50|regex:/^[a-zA-Z\s]+$/' ;
                   $rules['grade']             =  'required' ;
                   $rules['profession']        =  'required|regex:/^[a-zA-Z-_\s]*$/' ;
                }
                break ; 

                case 'company':
                {
                    $id_company = User::find($id)->userable->id ;
                    $rules  ['raison_sociale']   =  'max:100|unique:company,raison_sociale,'.$id_company ;
                }
                break ;

            }



            $request->flash(); // to flash the old inputs 
            $this->validate(request(),$rules);


            $user = User::find($id) ;

            $user->username = $request->input('username') ;
            $user->telephone= $request->input('telephone') ;

            switch ($person)
            {
                case 'student': 
                                $user->userable->nom         = strtoupper($request->input('nom'));
                                $user->userable->prenom      = $this->CustomFirstName($request->input('prenom'));
                                $user->userable->matricule   = $request->input('matricule') ;
                                $user->userable->specialite  = $request->input('specialite') ;
                    
                    break;
                
                case 'teacher':
                                $user->userable->nom         = strtoupper($request->input('nom'));
                                $user->userable->prenom      = $this->CustomFirstName($request->input('prenom'));
                                $user->userable->grade       = $request->input('grade');
                                $user->userable->profession  = $request->input('profession') ;

                    break;

                case 'company': $user->userable->Raison_sociale     = $request->input('raison_sociale') ; 
                    
                    break;
            }

            $user->save();
            $user->userable->save() ;

            //ProfilePhoto  updated !     
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) 
            {
                //delete  the existing image
                File::delete ( glob(   'storage/Users/'.$user->userable_type."/".$user->id.'/ProfileImage/*.jpg')  );
                //for security
                $token = str_random(20);

                $path = $request->photo->storeAs('Users/'.$user->userable_type."/".$user->id."/ProfileImage"
                 , $id.$token.'.jpg', 'public');
            }
            //END ProfilePhoto  updated !

            return redirect()->route('profile', ['person' => $person , 'id' => $id])->with('status', 'tab1'); 
    }

   
    
    public function updatePassword(Request $request , $person , $id )
    {

        


       $rules = 
       [
                'Mot_de_passe_courant'                            => 'required' ,
                'Nouveau_mot_de_passe'                            => 'required|min:8|max:30',
                'Confirmation_du_nouveau_mot_de_passe'           => 'required|same:Nouveau_mot_de_passe'
       ];

       $user =  User::find($id) ;

       if (   hash::check(  $request->input('Mot_de_passe_courant') , $user->password )  )
       {  
            $request->flash(); 
            $this->validate(request(),$rules);
       }
       else
       {
        return redirect()->route('profile', ['person' => $person , 'id' => $id])->withErrors
           ( ['Mot_de_passe_courant' => 'Veuillez introduire votre mot de passe courant correctement']);
       }
       
       $user->password  =  bcrypt($request->input('Nouveau_mot_de_passe'));
       $user->save() ;
        return redirect()->route('profile', ['person' => $person , 'id' => $id])->with('status', 'tab2'); 
    }



     //Searching
    public function  getSearchedPosts(Request $request , $person)
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
         
          
         $specialites['Licence'] =Specialite::where('niveau','Licence')->get();
         $specialites['Master'] =Specialite::where('niveau','Master')->get();
            
         
            //sorting credentials

        
            // Poster  Type
           $postTypesArray =  ($person == 'student') ? ['Teacher','Company'] : ['Student'] ;

        
            $posts = Post::whereHas('poster', 
                function ($query) use($postTypesArray)
             {
                        $query->whereIn('userable_type' ,$postTypesArray )
                         ;

             });

             

            //Post Keywords
             if(!empty($request->input('keywords'))) 
             {
                $keywordsarray = explode(" ", $request->input('keywords') );
                $posts = $posts->whereHas('keywords', 
                function ($query) use ($keywordsarray )
                 {
                            
                            $query->whereIn('keyword' , $keywordsarray );  

                 } );   


             }  
             
             if (  $request->advancedSearch )
            {
                //Post Specialites 
                 if( $request->input('specialite')    != 'Toutes les Specialités' )
                 {
                          
                          $posts = $posts->whereHas('specialites', 
                                function ($query) use($request)
                             {
                                        $query->where('spec' ,$request->input('specialite')  )
                                         ;

                             }) ;
                         
                          
                 }

                       
                 
                 //Post domaine
                 if( $request->input('domaine')    != 'Tout les domaines' )
                 {

                        $posts = $posts->where('domaine',$request->input('domaine') ) ; 
                 }
                 
                 //post oriente
                 if( $request->input('oriente') !='Orienté' )
                 {

                     $posts = $posts->where('oriente',$request->input('oriente')) ;
                 }
                
                 //post sorting created at  Asc / desc */
                 if (($request->input('order') == 'Plus récents') )
                 {
                    $posts = $posts->latest(); 
                 }
                 else if(($request->input('order') == 'Plus anciens'))
                {
                    $posts = $posts->oldest(); 
                 }

            }


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
                                                    $query->where('Etat','Affecté');
                                                    $query->whereHas('Poster',function($query)
                                                      {
                                                        $query->where('userable_id' , Student::where( 
                                                        'promoteur_interne_id' , Auth::user()->userable->id )->pluck('id')->first()) ;
                                                      });     
                                             })
                                              ;
                break;
              case 'company': $posts = $posts->where('Etat','En candidature')
                                             ->orWhere(function ($query)
                                             {
                                                    $query->where('Etat','Affecté');
                                                    $query->whereHas('Poster',function($query)
                                                      {
                                                        $query->where('userable_id' , Student::where( 
                                                        'promoteur_externe_id' , Representant::where(
                                                        'company_id',Auth::user()->userable->id)->pluck('id')->first() )->pluck('id')->first()) ;
                                                      });     
                                             })
                                             ;
                break;
            }
        
            $posts = $posts->withCount('comments')->with('poster')->get() ;

        $i=0 ; 
        foreach ($posts as $post)
        {
                  $posts[$i]->CommentsNumber = $post->comments->count() ;
                  $posts[$i]->Resume = $this->limit_text($post->Resume , 260 ) ;
                  $posts[$i]->userposter = $post->poster ;
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
                          $person == 'teacher' && isset($post->poster->userable->promoteur_interne) && 
                          // determine if the current teacher is Promoteur interne of the post
                          Auth::user()->userable->id == $post->poster->userable->promoteur_interne->id
                       ) 

                       ||

                       (
                         $person == 'company' && isset($post->poster->userable->promoteur_externe) && 
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

        $Employes = array() ;
        if($person == 'company')
         $Employes =  Auth::user()->userable->Representants ;
       
        $request->flash();
        return view('user.Pages.UserHome' , ['specialites' => $specialites , 'posts' => $posts,
                                                    'type' => $person ,'employes' => Auth::user()->userable->Representants  ]);
       
        
    }


     public function CustomFirstName($string)
    {
        $str = mb_convert_case( $string , MB_CASE_TITLE, "UTF-8");
                    $pos = strpos($str, "'");
                    if ($pos != FALSE)
                    {
                         $str[$pos+1] = strtoupper($str[$pos+1]);
                    }
        return $str ; 
    }

}
