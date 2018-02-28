<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\User ;
use App\Post ;
use App\Student ;
use App\Notification ;
 use App\http\traits\DeadLine_Trait ;

class StudentController extends Controller
{

     use  DeadLine_Trait  ;

    public function __construct(Request $request )
    {
        $this->middleware(['web', 'user', 'auth:student']);
    }

    public function RequestPost(Request $request)
    {

    	$student  =  User::find($request->user_id)->userable ; 

            if (is_null($student->AcceptedPost) )
            {
                //Notification
                $notified_user = Post::find($request->post_id)->poster ;
                $notification = new Notification() ;
                $notification->Titre  = 'Postulation reçue' ; 
                $notification->Content ='Vous venez de recevoir une postulation pour le sujet : '.Post::find($request->post_id)->Titre .' de la part de '.$student->Nom.' '.$student->Prenom ; 

                $notification->user()->associate($notified_user);
                $notification->save() ;
                //END Notification
                $student->requestedPosts()->attach($request->post_id);
                return response()->json(['title' => Post::find($request->post_id)->Titre ]);
            }
            else
            {
                return response()->json(['msg' => "Erreur ! Vous venez d'avoir un promoteur il est maintenant
                    impossible de postuler pour des sujets .Patientez pendant que votre page se rechargera"] , 403 );
            }
            
        
    }

    public function DeleteRequestPost(Request $request)
    {
    	
            
            $student  =  User::find($request->user_id)->userable ; 
            $student->requestedPosts()->detach($request->post_id);
            return response()->json(['title' => Post::find($request->post_id)->Titre ]);
        
    }

    

    public function Cursus ($id)
    {


        $input = Input::all();
        $rules = [
                      'file' => 'image|max:3072'
                 ] ;

        $validation = Validator::make($input, $rules);

        if ($validation->fails())
        {
            return response()->make('Erreur Veuillez vérifier la taille de votre Fichier( ≤ 3MB )
            ainsi que son type (image)', 400);
        }

        $file = Input::file('file');

        $time = date("Y_m_d_H_i_s");
        $extension = $file->getClientOriginalExtension();
        $filename = $time.".".$extension;
        $path = "Users/Student/".$id."/Cursus" ;
        $disk = 'public' ;

        
        $path = $file->storeAs( $path , $filename , $disk );





        if( $path ) {
            return response()->json('success', 200);
        } else {
            return response()->json('error', 400);
        }
    }

    public function getExistingCursus ($id)
    {
        $Paths = glob( 'storage/Users/Student/'.$id.'/Cursus/*') ;

        $Files = array() ;
        
        foreach ($Paths as $FilePath)
        {
            $Files[] = [ 'name' => '/'.$FilePath  , 'size' => filesize($FilePath) ] ;
        }
        return response()->json( ['Files' => $Files]  );
    }

    public function RemoveCursusFile (Request $request ,$id)
    {
        $path = 'storage/Users/Student/'.$id.'/Cursus/'.$request->filename ;
       
            File::delete($path) ;
            return response()->json( ['test' =>'storage/Users/Student/'.$id.'/Cursus/'.$request->filename  ]  );
    }


    public function setMoyennes(Request $request , $id) 
    {
        $rules = 
        [
            '1ere_année' => 'required|numeric|min:0|max:20' , 
            '2eme_année' => 'required|numeric|min:0|max:20' ,
        ] ;

        if ( User::find($id)->userable->specia->niveau =='Master' )
        {
            $rules['3eme_année'] = 'required|numeric|min:0|max:20' ;
            $rules['Master_1']   = 'required|numeric|min:0|max:20' ;
        }

        
        $request->flash(); // to flash the old inputs 
        $this->validate(request(),$rules);

        $student = User::find($id)->userable ;
        $student->Cursus()->detach();
        $student->Cursus()->attach('L1',['Moyenne' =>$request->input('1ere_année') ]);
        $student->Cursus()->attach('L2',['Moyenne' =>$request->input('2eme_année') ]);
        if($student->specia->niveau == 'Master' )
        {
            $student->Cursus()->attach('L3',['Moyenne' =>$request->input('3eme_année') ]);
            $student->Cursus()->attach('M1',['Moyenne' =>$request->input('Master_1') ]);
        }

        return back()->with('status', 'tab3' )->withInput([]); 

    }

   
   public function MyApplications($id)
   {
        $student =User::find($id)->userable ;
        if( $student->AcceptedPost )
        { 
          $Binome = $student->Binome ;
          $str = ($Binome) ? ' Vous êtes en ce moment en binôme avec '.$Binome->Nom.' '.$Binome->Prenom : 
                             ' Vous êtes en ce moment Monôme' ;
          $promoteur = ( $student->promoteur_interne ) ? $student->promoteur_interne->Nom.' '. $student->promoteur_interne->Prenom  :  $student->promoteur_externe->Nom.' '.$student->promoteur_externe->Prenom.' appartenant à '.$student->promoteur_externe->Company->Raison_sociale ;
          
          $str = $str.'<br>Encadré par : '.$promoteur.'<br>Votre sujet est :<b>'.$student->AcceptedPost->Titre.'</b>' .'<br> VOUS POUVEZ COMMENCER A TRAVAILLER'; 
          return view ('errors.MentoredStudent' , [ 'msg' => $str ]) ;
        }

        $view = $this->DeadlineCheck('Candidature') ;
        if ( !$view  )
        
        {  
            $posts =  $student->requestedPosts ;
            return view('user.student.ApplicationsSent' , ['posts' => $posts] ) ;
        }
        else
        {
              $view['data']['msg'] ='Vous devez patienter pour une période ultérieure déstinée aux candidatures'  ;
            return view ($view['page'] , $view['data'] ) ;
        }
   }

   public function DeleteApplication(Request $request)
   {
        $student = Student::find($request->student_id) ;
         $student->requestedPosts()->wherePivot('Post_id',$request->post_id)->detach() ;
         return response()->json([
                                    'post_id'=> $request->post_id 
                                    ]);
   }
    public function BinomePage($id)
    {
        $view = $this->DeadlineCheck('Soumission') ;
        $Student = User::find($id)->userable ;
        $Binome = $Student->Binome ;

        if( $Student->AcceptedPost )
        { 
          $Binome = $Student->Binome ;
          $str = ($Binome) ? ' Vous êtes en ce moment en binôme avec '.$Binome->Nom.' '.$Binome->Prenom : 
                             ' Vous êtes en ce moment Monôme' ;
          $promoteur = ( $Student->promoteur_interne ) ? $Student->promoteur_interne->Nom.' '. $Student->promoteur_interne->Prenom  :  $Student->promoteur_externe->Nom.' '.$Student->promoteur_externe->Prenom.' appartenant à '.$Student->promoteur_externe->Company->Raison_sociale ;
          
          $str = $str.'<br>Encadré par : '.$promoteur.'<br>Votre sujet est :<b>'.$Student->AcceptedPost->Titre.'</b>' .'<br> VOUS POUVEZ COMMENCER A TRAVAILLER'; 
          return view ('errors.MentoredStudent' , [ 'msg' => $str ]) ;
        }
        if ( !$view  )
        
        {
            
            $BinomeRequesters  =  $Student->BinomeRequesters ;
            $i=0 ;
            foreach ($BinomeRequesters as $BinomeRequester)
            {
                  $path = 'storage/Users/Student/'.$BinomeRequester->user->id.'/ProfileImage/*.jpg' ;                 
                  $photoarray = glob($path) ; 
                  $bool = !empty($photoarray) ; 
                  $BinomeRequesters[$i]['imagePath'] =  $bool  ?   $photoarray[0]    : "storage/Users/no-image.jpg" ; 
                  $i++ ;
            }
        
        return view ('user.student.BinomeAll' , ['Binome' => $Binome , 'BinomeRequesters' => $BinomeRequesters]) ;
        }
        else
        {
            $str = ($Binome) ? ' Vous êtes en ce moment en binôme avec '.$Binome->Nom.' '.$Binome->Prenom : 
                               'Vous êtes en ce moment Monôme' ;
             $view['data']['msg'] = $str.". <br> Il est maintenant impossible de modifier ce fait" ;
            return view ($view['page'] , $view['data'] ) ;
        }
    }

    public function RemoveBinome($id)
    {
        $Student = User::find($id)->userable ;
        $Binome  = $Student->Binome ;
        
        $Student->Binome_id = null  ; $Student->save() ;
        $Binome->Binome_id  = null  ;  $Binome->save()  ;

        return back()->with('status', 'Student Monome'); 
    }

    public function  RequestBinome(Request $request)
    {

        $Student = User::find($request->user_id)->userable ;

        if (  $Student->Binome == null )
        {
            $messages = [
                            'exists' => 'Le matricule que vous venez dintroduire est  inéxistant',
                        ];
            $rules =    [
                            'matricule' => 'required|exists:student|digits:12' 
                        ] ;


            $validator = Validator::make($request->all(),$rules , $messages);
             if ($validator->fails()) {
                return response()->json([ 'errors' => $validator->errors()->all() ] , 403);
            }

            // getting  the student Requester
             if ( $Student->Matricule == $request->matricule )
            {
                return response()->json([ 'errors' => ["Il est Impossible d'envoyer une demande à Soi-même !"]] , 403);
            }


            
            $RequestedStudent = Student::where('matricule',$request->matricule)->first() ;

            

            if ( $RequestedStudent->BinomeRequesters->contains($Student->id) )
            {
                return response()->json([ 'errors' => ['Vous avez déjà envoyé une demande à cet Etudiant']] , 403);
            }
            

            // link it with  the receiver student 
            $RequestedStudent->BinomeRequesters()->attach($Student->id) ;

            //Notification
                $notified_user = $RequestedStudent->user ;
                $notification = new Notification() ;
                $notification->Titre  = 'Demande Binôme reçue' ; 
                $notification->Content ='Vous venez de recevoir une Demande binôme de la part de '.$Student->Nom.' '.$Student->Prenom ; 

                $notification->user()->associate($notified_user);
                $notification->save() ;
            //END Notification

            return response()->json(['Nom' => $RequestedStudent->Nom , 'Prenom' => $RequestedStudent->Prenom ]);
        }
        else
        {
            return response()->json(['errors' => ["Vous n'êtes plus Monôme . Vous êtes Binôme avec ".$Student->Binome->Nom." ".$Student->Binome->Prenom." ! Patienter pendant que la page se rechargera" ] ,
                 'check' => 'current_student' ] , 403);
        }
    }

    public function RespondBinome (Request $request)
    {
         $Student = User::find($request->user_id)->userable ; 

         $StudentRequester = Student::find($request->student_id) ; 
         
        if ( $request->respond =='accept')
        {
            if( $Student->Binome == null )
            {

                if( $StudentRequester->Binome == null )
                {
                    

                    // Linking between them
                    $Student->Binome_id = $StudentRequester->id ;$Student->save() ;
                    $StudentRequester->Binome_id = $Student->id ;$StudentRequester->save() ;

                    //destroy BinomeRequest from Binome_Demande Table
                    $Student->BinomeRequesters()->wherePivot('student2_id', $StudentRequester->id )->detach() ;
                    //Notification
                    $notified_user = $StudentRequester->user ;
                    $notification = new Notification() ;
                    $notification->Titre  = 'Demande Binôme acceptée' ; 
                    $notification->Content ='Votre Demande binôme a été acceptée ! Votre Binôme est : '.$Student->Nom.' '.$Student->Prenom ; 
                    $notification->user()->associate($notified_user);
                    $notification->save() ;
                    //END Notification
                    return response()->json(['msg' => 'Vous êtes maintenant Binôme avec '.$StudentRequester->Nom.' '.
                        $StudentRequester->Prenom.'<br> Patienter pendant que la page se rechargera',
                        'check' => 'accept']);
                } 

                else
                {
                    //not necessary
                    $Student->BinomeRequesters()->wherePivot('student2_id', $StudentRequester->id )->detach() ;

                    return response()->json([ 'errors' => "Erreur ! Cet étudiant n'est plus Monôme" ,'toDelete' =>
                     $StudentRequester->id] , 403);
                }


            }

            else
            {
                return response()->json(['errors' => "Erreur ! Vous n'êtes plus Monôme . Vous êtes Binôme avec ".$Student->Binome->Nom." ".$Student->Binome->Prenom." ! Patienter pendant que la page se rechargera"  ,
                 'check' => 'current_student' ] , 403);
            }

        }
        
        

        if ( $request->respond =='refuse' )
        {
            

            $Student->BinomeRequesters()->wherePivot('Student2_id', $StudentRequester->id )->detach() ;

            //Notification
                    $notified_user = $StudentRequester->user ;
                    $notification = new Notification() ;
                    $notification->Titre  = 'Demande Binôme refusée' ; 
                    $notification->Content ='Votre Demande binôme a été refusée de la part de : '.$Student->Nom.' '.$Student->Prenom ; 

                    $notification->user()->associate($notified_user);
                    $notification->save() ;
            //END Notification
            return response()->json(['msg' => 'Demande Binôme refusée avec succès'  ]);
        }   
    }

}
