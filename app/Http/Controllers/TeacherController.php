<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User ;
use App\Post ;
use App\Student ;
use Illuminate\Support\Facades\Auth;
use App\Http\traits\Promoteur ;

/*Note Most methods are in the Promoteur Trait to avoid Repition*/ 

class TeacherController extends Controller
{
    
    use Promoteur ;

    public function __construct(Request $request )
    {
        $this->middleware(['web', 'user', 'auth:teacher']);
    }


    public function MyPostsTovalidate($id)
    {
          $view = $this->DeadlineCheck('Validation') ;
      
       if ( !$view  ) 
      {
        $teacher = User::find($id)->userable ; 
        
        $posts = $teacher->PostsToValidate ;
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

        return View('User.teacher.PostsToValidate' , ['posts' => $posts ]) ;
      }

      else
      {
              $view['data']['msg'] ='Vous devez patienter pour une période ultérieure déstinée à la validation des sujets .'  ;
            return view ($view['page'] , $view['data'] ) ;
      }
    }

    public function showPostToValidate ($id)
    {



         //retrieving the post
         $post = Post::find($id) ;
         //Retrieving image
         $bool = !empty(glob('storage/Postimages/'.$id.'*.jpg')) ; 
         $pathToImage = $bool  ?  glob('storage/Postimages/'.$id.'*.jpg')[0]  : ''   ;
         //Formatting  Date + Time 
         setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //French
         $post->created = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->created_at) )   ;
         $post->updated = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->updated_at) )    ;
         $post->userposter = $post->poster ;
         $boolreserve = $post->Validators()->where('teacher_id',Auth::user()->userable->id)->count() > 0 ;
         if ( $boolreserve )
         $post->reserve = $post->Validators()->where('teacher_id',Auth::user()->userable->id)->first()
         ->pivot->Reserve ;

         $post['display'] = $post->Etat == 'En cours de validation' ||  $post->Etat == 'Validé sous reserve' ;




        return View('user.teacher.showPostToValidate' , 
            [
                             'post'   => $post ,
                       "pathToImage"  => $pathToImage   ,
                        "specialites" => $post->specialites,    
            ]);



    }



     

    public function refuser( Request $request , $post_id)
    {
        $post = Post::find($post_id) ;
        if ( $post->Etat == 'Validé' )
        {
            return back()->with(['status' => 'bad', 'msg' => "Erreur ! Ce sujet vient d'avoir 2 avis favorables de la part de deux autres enseigants ! il est maintenant impossible de le refuser "] ) ;
        }
        else
        {
            //Post is arrived to its Final State  so detach it from any validator
            $post->Validators()->detach() ;

            $post->Etat = 'Refusé' ;
            $post->save() ;
            return back()->with(['status' => 'good', 'msg' => "Ce sujet a été refusé  avec succès !"] ) ;
        }
    }

    public function valider( Request $request , $post_id)
    {
        $post = Post::find($post_id) ;

        if( $post->Etat == 'Refusé' )
        {
            return back()->with(['status' => 'bad', 'msg' => "Erreur ! Ce sujet vient d'avoir 2 avis défavorables de la part de deux autres enseigants ! il est maintenant impossible de le valider"] ) ;
        }
        else
        {
            
            if($post->Etat == 'En cours de validation' || $post->Etat == 'Validé sous reserve' ) 
            {
                $post->NbrAvisFav ++ ;


                $post->save() ;
                if ( $post->NbrAvisFav == 2)
                {
                    //Post is arrived to its Final State  so detach it from any validator
                   
                    
                    $post->Etat = 'Validé' ;
                    $post->save() ;
                    $post->Validators()->detach() ;
                return back()->with(['status' => 'good', 'msg' => "Ce sujet vient d'avoir un deuxième avis favorable 
                    de votre part il est donc Validé avec succès !"] ) ;
                }
                else
                {
                     $teacher = User::find($request->input('user_id'))->userable ;
                    
                    // he gives his latest answer for the subject  he can t change it !  so detaching him  from this post
                    $post->Validators()->where('teacher_id',$teacher->id)->detach() ;
                    return back()->with(['status' => 'good', 'msg' => " Ce sujet vient d'avoir un  avis favorable de votre part avec succés"] ) ;
                }
            }
            else
              abort(500) ;
            
        }
    }

    public function validerSousReserve( Request $request ,  $post_id )
    {
        
        
        $post = Post::find($post_id) ;
        if( $post->Etat == 'Refusé' )
        {
            return back()->with(['status' => 'bad', 'msg' => "Erreur ! Ce sujet vient d'avoir 2 avis défavorables de la part de deux autres enseigants ! il est maintenant impossible de le valider"] ) ;
        }
        else
        {
            if($post->Etat == 'Validé') 
            {
                return back()->with(['status' => 'bad', 'msg' => "Erreur ! Ce sujet vient d'avoir 2 avis favorables de la part de deux autres enseigants ! il a été donc automatiquement validé"] ) ;
            } 
            //Sujet  il est ni validé ni refusé
            else
            {
                $teacher = User::find($request->input('user_id'))->userable ;
                $post->Etat = 'Validé sous reserve' ;

                $post->Validators()->updateExistingPivot($teacher->id,['Reserve' => $request->input('Reserve')])  ;
                $post->save() ;
                return back()->with(['status' => 'good' , 'except' => 'reserve' , 'msg' => "Ce sujet vient d'être validé sous réserve avec succès ! "] ) ;

            }

            $post = Post::find(1) ;
                    }

    }



}
