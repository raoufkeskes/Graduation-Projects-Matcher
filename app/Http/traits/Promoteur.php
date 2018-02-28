<?php 

namespace App\Http\traits ;
use App\User ;
use App\Post ;
use App\Student ;
use App\Notification ;
use  App\Representant ;
use Illuminate\Http\Request;
 use App\http\traits\DeadLine_Trait ;

trait Promoteur
{
    use limit_text_Trait , DeadLine_Trait ;



    public function showStudentDetails(Request $request)
    {
        $Binome = null ;
        
        // intern function   to not repeat myself
         $Student = $this->getStudentData($request->user_id);

        // if the student has Binome get all binome s Data
        if ( ! is_null($Student->Binome)  )
        {
          $Binome = $this->getStudentData($Student->Binome->user->id) ;
        }


        

        return response()->json(['Student' => $Student , 'Binome' => $Binome  ]);
    }



    public function MyMentoredPosts($id)
    {

       $view = $this->DeadlineCheck('Candidature') ;
       if ( !$view  ) 
      {
      
       $promoteur = User::find($id)->userable ; 
       $type      = User::find($id)->userable_type ;
       $promoteurQuery  = ($type == 'Teacher')  ?  'Promoteur_interne_id' :  'Promoteur_externe_id' ; 

        //Getting all Posts where teacher s a Promoteur
        $posts = Post::whereIn('id',
        Student::where($promoteurQuery,$promoteur->id)->pluck('AcceptedPost_id')->all() )->get() ;
        
        $i=0 ; 
        foreach ($posts as $post)
        {
                  $posts[$i]->Resume = $this->limit_text($post->Resume , 260 ) ;
                  $posts[$i]->userposter = $post->poster ;
                  //  Post  photo 
                  $bool = !empty(glob('storage/Postimages/'.$post->id.'*.jpg')) ; 
                  $posts[$i]->imagePath =  $bool  ?   glob('storage/Postimages/'.$post->id.'*.jpg')[0]    : "" ; 
                  //DateTime Format
                  setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //French

                  $posts[$i]->created = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->created_at) )   ;
                  $posts[$i]->updated = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->updated_at) )    ;
        $i++ ;
                                  
        }


        return View('User.'.strtolower($type).'.MentoredPosts' , ['posts' => $posts ]) ;
        }
      else
      {
              $view['data']['msg'] ='Vous devez patienter pour une période ultérieure déstinée aux candidatures pour visualiser la Liste des sujets dont vous serez Promoteur'  ;
            return view ($view['page'] , $view['data'] ) ;
      }
    }

    public function ReceivedApplications($id)
    {

      $view = $this->DeadlineCheck('Candidature') ;
       if ( !$view  ) 
      { 

        $receiver = User::find($id) ;
        $type     = $receiver->userable_type ;
        
        

        $posts = $receiver->Posts()->has('StudentsRequesters')->with
        (['StudentsRequesters' => function ($query)
        {
                        $query->where('is_Blocked',0)->latest()->with('user');
        }])->get();


        foreach ($posts as $post)
        {

          $i = 0 ;
          $students = $post->StudentsRequesters ;
          foreach ($students as $student)
          {

            setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //French         
            $students[$i]['created'] = strftime('%A %d %B %Y à %H:%M' ,strtotime( $student->pivot->created_at) )   ;
            $path = 'storage/Users/Student/'.$student->user->id .'/ProfileImage/*.jpg' ;                 
            $photoarray = glob($path) ; 
            $bool = !empty($photoarray) ; 
            $students[$i]['imagePath'] =  $bool  ?   $photoarray[0]    : "storage/Users/no-image.jpg" ; 
            $students[$i]['user_id']   = $student->user->id ;
            $i++ ;   
          }

        }

        $employes = array()  ;
        if ($type  == 'Company')

            $employes = User::find($id)->userable->Representants ;


        return View('User.'.strtolower($type).'.ReceivedApplications' , ['posts' => $posts , 'employes' => $employes ]) ;
      }
        else
        {
              $view['data']['msg'] ='Vous devez patienter pour une période ultérieure déstinée aux candidatures'  ;
            return view ($view['page'] , $view['data'] ) ;
        }
    }


    public function MentorPost(Request $request)
    {
              
             $user     = User::find($request->user_id) ;
             $student  = User::find($request->student_id)->userable ;
             $post     = Post::find($request->post_id) ;

             
      if( is_null( ($student->AcceptedPost)  )  ) 
       {
             $promoteurType = $user->userable_type ;
             $promoteur = $user->userable ;
             $enacadreur = '' ;

             if ($promoteurType =='Teacher')
             {
                // Linking between teacher & student 
                 $student->Promoteur_interne()->associate($promoteur) ;
                //same for his binome 
                 if ( !is_null($student->Binome)  )
                {
                     $student->Binome->Promoteur_interne()->associate($promoteur) ;
                }

                $encadreur  =  ' '.$promoteur->Nom.' '.$promoteur->Prenom.' ' ;


             }
             else
             {
                  $company = $user->userable ;
                   //Company
                  $formarray = array() ;
                    //because of serilize method
                  parse_str($_POST['form'], $formarray);

                  if ( !isset($formarray['EmployeExist']) ) // new Employee
                  {
                      
                      $representant = new Representant() ;
                      $representant->nom      = $formarray['nom'] ;
                      $representant->prenom     = $formarray['prenom'] ;
                      $representant->service    = $formarray['service'] ;
                      $representant->grade      = $formarray['grade'] ;
                      $representant->profession   = $formarray['profession'] ;
                      //link him to the company
                      $representant->Company()->associate($company);
                      $representant->save();
                      
                  }
                  else
                  {
                    $representant = Representant::find($formarray['EmployeExist']) ;
                  }
                
                // Linking between Representant  & student 
                 $student->Promoteur_externe()->associate($representant) ;  
                 $encadreur  =  ' '.$representant->Nom.' '.$representant->Prenom.' appartenant à '.$company->Raison_sociale ;              
                 if ( !is_null($student->Binome)  )
                {
                     $student->Binome->Promoteur_externe()->associate($promoteur) ;
                }
                

             }
                
              //assign the student to its post as the accepted one haha
               $student->AcceptedPost()->associate($post) ;

               //*When the teacher answer the student s application
               if ( count ($student->requestedPosts()) > 0 ) 
              {
                //Remove  current Application   
               
                $student->requestedPosts()->wherePivot('Post_id',$post->id)->detach() ;
                //Block Applications for other posts
                  $student->requestedPosts()->where('Post_id','<>',$post->id)->update(['is_Blocked' => 1]); 
               }

               $student->save() ;
              // Same Logic for student s Binome
              if ( !is_null($student->Binome)  )
              {
                   $student->Binome->AcceptedPost()->associate($post) ;
                    //When the teacher answer the student s application
                  if ( count ($student->Binome->requestedPosts()) > 0 ) 
                  {
                    //Remove  current Application   
                     
                    $student->Binome->requestedPosts()->wherePivot('Post_id',$post->id)->detach() ;
                    //Block Applications for other posts
                    $student->Binome->requestedPosts()->where('Post_id','<>',$post->id)->update(['is_Blocked' => 1]); 
                   }
                   $student->Binome->save() ;
                   $post->StudentsRequesters()->where('id','<>',$student->id)->detach() ;
              }


                 //change state of posts

                // the student post
                $post = Post::find($request->post_id);
                $post->Etat ='Affecté' ;
                $post->save() ;

                $OtherStudentPosts = $student->user->posts()->where('Etat','<>','Affecté')
                ->update(['Etat' => 'Bloqué']);
                if ( !is_null($student->Binome)  )
                  $BinomePosts = $student->Binome->user->posts()->where('Etat','<>','Affecté')
                  ->update(['Etat' => 'Bloqué']);
                //End Posts States 

                    //Notification 
                     if ( $request->notif_type == 'encadrement' )
                    {
                      

                      $notified_user = $student->user ;
                      $notification = new Notification() ;
                      $notification->Titre  = 'Promoteur' ; 
                      $notification->Content ='Votre sujet "'.$post->Titre.'" a été encadré par :'.$encadreur ; 
                      $notification->user()->associate($notified_user);
                      if (!is_null($student->Binome))
                        $notification->user()->associate($student->Binome->user);
                      $notification->save() ;
                      
                    }
                    else
                    {
                      $notified_user = $student->user ;
                      $notification = new Notification() ;
                      $notification->Titre  = 'Promoteur' ; 
                      $notification->Content ='Votre postulation pour le sujet "'.$post->Titre.'" a été acceptée vous êtes maintenant encadré par :'.$encadreur ; 
                      $notification->user()->associate($notified_user);
                      if (!is_null($student->Binome))
                        $notification->user()->associate($student->Binome->user);
                      $notification->save() ;

                      $RefusedStudents = $post->StudentsRequesters()->where('student_id','<>',$student->id)->
                      orWhere('student_id','<>',$student->Binome->id)->get() ;
                      foreach ($RefusedStudents as $RefusedStudent)
                      {
                        $notified_user = $RefusedStudent->user;
                        $notification = new Notification() ;
                        $notification->Titre  = 'Promoteur' ; 
                        $notification->Content ='Votre postulation pour le sujet "'.$post->Titre.'" a été refusée ' ; ; 
                        $notification->user()->associate($notified_user);
                        if (!is_null($student->Binome))
                          $notification->user()->associate($RefusedStudent->Binome->user);
                        $notification->save() ;
                      }
                    }
                    //END Notification 
                    


            return response()->json(['title'    => Post::find($request->post_id)->Titre ,
                                    'post_id'   => $request->post_id,
                                    'poster_id' => $student->user->id ,
                                    'binome_id' => !is_null($student->Binome) ? $student->Binome->user->id : 'nothing'
                                    ]);
        }
       else
       { // if the student  get a Promoteur   at the same time    so  refuse  it 
           return response()->json([
                                    'msg'       => "Erreur ! Cet Etudiant vient de trouver un promoteur , il  est donc maintenant impossible de l'encadrer" ,
                                    'poster_id' => $student->user->id ,
                                    'binome_id' => !is_null($student->Binome) ? $student->Binome->user->id : 'nothing'
                                   ] , 403 );
       }
        
    }

    public function DeleteMentorPost(Request $request)
    {
             $user     = User::find($request->user_id) ;
             $student  = User::find($request->student_id)->userable ;
             

             

             $promoteurType = $user->userable_type ;
             


             if ($promoteurType == 'Teacher')
             {
                // Linking between teacher & student 
                 $student->Promoteur_interne()->dissociate() ;
                //same for his binome 
                 if ( !is_null($student->Binome)  )
                {
                     $student->Binome->Promoteur_interne()->dissociate()  ;
                }
             }
             else
             {

                 $ExterneId = $student->Promoteur_externe->id ;
                 $student->Promoteur_externe()->dissociate() ;                
                 if ( !is_null($student->Binome)  )
                {
                     $student->Binome->Promoteur_externe()->dissociate() ;
                }
                    
                    $representant = Representant::find($ExterneId) ;
                    // if the Representant  has no students to mentor  so delete him !
                    if ( $representant->MentoredStudents()->count() == 0 )
                    {
                      Representant::find($ExterneId)->delete() ;
                      // to remove it from Select options
                      $removedOption = $representant->id ;
                      $remove = true ;
                    }
                    //end delete him
             }
                
              //assign the student to its post as the accepted one haha
               $student->AcceptedPost()->dissociate() ;
                if ( count ($student->requestedPosts()) > 0 ) 
              {
                  $student->requestedPosts()->update(['is_Blocked' => 0]); 
              }
               $student->save() ;
              // Same Logic for student s Binome
              if ( !is_null($student->Binome)  )
              {
                   $student->Binome->AcceptedPost()->dissociate() ;
                     if ( count ($student->Binome->requestedPosts()) > 0 ) 
                  {
                      $student->Binome->requestedPosts()->update(['is_Blocked' => 0]); 
                  }
                   $student->Binome->save() ;
              }


                 //change state of posts
                $StudentPosts = $student->user->posts()->update(['Etat' => 'En candidature']);
                if ( !is_null($student->Binome)  )
                  $BinomePosts = $student->Binome()->user->posts()->update(['Etat' => 'En candidature']);

                //End Posts States 


            return response()->json(['title' => Post::find($request->post_id)->Titre ,
                                    'post_id'=> $request->post_id ,
                                    'poster_id' => $student->user->id 
                                     ]);
        
    }

    

    public function refuserPostulation (Request $request)
    {
         $student = Student::find($request->student_id) ;
         $student->requestedPosts()->wherePivot('Post_id',$request->post_id)->detach() ;
         return response()->json([
                                    'post_id'=> $request->post_id ,
                                    'poster_id' => $student->user->id ,
                                    'binome_id' => !is_null($student->Binome) ? $student->Binome->user->id : 'nothing'
                                    ]);
    }

    public function getStudentData( $id )
    {
         /*Student Data*/ 
        $student  =  User::find($id)->userable ; 
        $student['email'] = $student->user->email ;
        $student['specialite'] = $student->specia ;
        $student['Statut'] =  is_null($student->Binome) ? 'Monome' : 'Binome' ;
        $annees = $student->cursus ;
        $studentCursus = array() ;
        foreach ($annees as $annee) 
        {
            $studentCursus[$annee->annee] = ($annee->students->find($student->id)->pivot->Moyenne) ;
        }
        $student['Moyennes'] = $studentCursus ;

        // Cursus Images 
        $path = "Users/Student/".$id."/Cursus" ;
        $student['images'] = glob(   'storage/'.$path.'/*') ;
        // End 

        // End student Data

        return $student ;
    }
}









 