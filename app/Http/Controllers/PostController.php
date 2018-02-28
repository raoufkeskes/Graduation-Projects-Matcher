<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialite ;
use App\Keyword ;
use App\Post ;
use App\User ;
use App\Teacher ;
use App\Student ;
use  Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File ;
use Illuminate\Support\Facades\Auth;
use App\http\traits\limit_text_Trait ;
 use App\http\traits\DeadLine_Trait ;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use limit_text_Trait , DeadLine_Trait  ;


    protected $type ; 

    public function __construct(Request $request )
    {
        
        
        $this->type  = explode("/",(pathinfo($request->path() , 1 ) ))[0];
        $this->middleware(['web', 'user', 'auth:'.$this->type]) ->only('create','index','edit','show','getSearchedPosts');
        
    }

    public function index(Request $request)
    {
            $user = Auth::user();
            $posts = $user->posts()->get() ; 
            $i = 0 ; 
            foreach ($posts as  $post)
             {
                  $posts[$i]->CommentsNumber = $post->comments()->count() ;
                  $posts[$i]->Resume = $this->limit_text($post->Resume , 120 ) ;
                  $bool = !empty(glob('storage/Postimages/'.$post->id.'*.jpg')) ; 
                  $posts[$i]->imagePath =  $bool  ?   glob('storage/Postimages/'.$post->id.'*.jpg')[0]    : "" ; 
                  //DateTime Format
                  setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //French
                  $posts[$i]->created = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->created_at) )   ;
                  $posts[$i]->updated = strftime('%A %d %B %Y à %H:%M' ,strtotime( $post->updated_at) )    ;
                 
                  $test = array() ;
                  foreach ($post->Validators as  $validator)
                  {
                       $test[] =   $validator->pivot->Reserve   ; 
                  }
                     $posts[$i]['Reserves'] = $test ;
                  $i++;
             }

           



             
            

            return view('user.Pages.MyPosts',['posts' => $posts]) ; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {

        $view = $this->DeadlineCheck('Soumission') ;

        if ( !$view  )
        
        {
         $specialites['Licence'] =Specialite::where('niveau','Licence')->get();
         $specialites['Master'] =Specialite::where('niveau','Master')->get();
         $teachers = Teacher::select('Nom','Prenom')->get() ;
         

          $data = ['specialites' => $specialites , 'type'=>$this->type ,'teachers'=>$teachers] ;
         

        return view('user.'.$this->type.'.CreatePost' , $data ) ;
        }
        else
        {

            $view['data']['msg'] = 'Il est maintenant impossible de proposer un sujet ' ;
            
            return view ($view['page'] , $view['data'] ) ;
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,  $type)
    {
       

       
    


        
        $rules = 
        [
            'titre'          =>  'required|max:200' ,
            'domaine'        =>  'required', 
            'resume'         =>  'required|max:65000',
            'workplan'       =>  'required|max:65000',
            'photo'          =>  'mimes:jpeg,jpg,png'
        ] ;
       
        
        


        
        

        $request->flash(); // to flash the old inputs 
        $this->validate(request(),$rules);

        
        //create post 
        $post = new Post() ;
        $post->titre         = $request->input('titre');
        $post->domaine       = $request->input('domaine');
        $post->resume        = $request->input('resume');
        $post->workplan      = $request->input('workplan');
        $post->oriente       = $request->input('oriente');
        $post->etat          = 'En proposition';
        $post->type          =  ($this->type =='company')  ? 'externe' : 'interne' ;
        $post->poster_id     = $request->input('poster_id');
        $post->save();

        //if the poster add keywords 
        $KeywordsFromTitle = preg_replace('!\s+!', ' ', $request->input('titre'));
        $KeywordsFromTitle = str_replace(' ',',', $KeywordsFromTitle) ;
        $tags =
        (     !is_null($request->input('tags'))    &&     !empty($request->input('tags'))         ) 
        ? ','.$request->input('tags') : '' ; 

        $FullKeywordString = /*$KeywordsFromTitle.*/$tags ;
        $this->InsertingKeywords($post,$FullKeywordString);

        //specialités  visées 
        $specialites = array() ; 
        $user = User::find($request->input('poster_id')) ; 

        if ($user->userable_type == 'Student')
        {
            $specialites[0] = $user->userable->specialite ;
        }
        else
        {
            $specialites = ($request->input('destinea'));
        }


        if(! empty($specialites))
            
            $post->specialites()->attach($specialites) ; 

        //photo
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) 
        {
            //for security
                $token = $this->randomString(20);
            $path = $request->photo->storeAs('Postimages', $post->id.$token.'.jpg', 'public');
                        
        }

        
         return back()->with('status', trans($type))->withInput([]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($person , $id)
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
         $post->CommentsNumber = $post->comments->count() ;
         $post->userposter = $post->poster->username ;
         $comments = $post->comments()->oldest()->get() ;
         
         
         $i=0 ;
        
         
         foreach ($comments as $comment)
         {        

                  

                  
                   //Commentator  photo 
                  $path = 'storage/Users/'.$comment->commentator->userable_type."/".$comment->commentator->id.'/ProfileImage/*.jpg' ;
                $comments[$i]['commentator_id'] = ($comment->commentator->id)    ;  
                  $photoarray = glob($path) ; 
                  $bool = !empty($photoarray) ; 
                  $comments[$i]['imagePath'] =  $bool  ?   $photoarray[0]    : "storage/Users/no-image.jpg" ; 
                  //DateTime Format for Comment
                  $comments[$i]['commentator'] = $comment->commentator->userable_type != 'Company'
                  ? $comment->commentator->userable->Nom.' '.$comment->commentator->userable->Prenom
                  : $comment->commentator->userable->Raison_sociale ;
                  

                  //DateTime Format for Comment
                  setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //French
                  $comments[$i]['updated'] = strftime('%d %B %Y à %H:%M' ,strtotime( $comment->updated_at) )    ;
                 
                  
                  $i++ ;
         }

         


         

        return View('user.Pages.ShowPost' , 
            [
                             'post'   => $post ,
                       "pathToImage"  => $pathToImage   ,
                         "keywords"   => $post->keywords , 
                        "specialites" => $post->specialites,
                        "comments"    => $comments
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($person , $id)
    {

        
        
        $view = $this->DeadlineCheck('Soumission') ;
        if ( !$view  )
        
        {
                $specialites['Licence'] =Specialite::where('niveau','Licence')->get();
                $specialites['Master'] =Specialite::where('niveau','Master')->get();

                $post = Post::find($id) ;
                
                 $bool = !empty(glob('storage/Postimages/'.$id.'*.jpg')) ; 

                  $pathToImage = $bool  ?  glob('storage/Postimages/'.$id.'*.jpg')[0]  :
                                          'storage/Postimages/aucune-image-disponible.png'   ;

                  


                //preparing   keywords
                //because the keyword input has a certain format : exemple 'one,two,three'
                 $KeywordsString = $this->DataCustomString($post->keywords ,'keyword') ;
                
                //same for specialites
                $SpecialiteString =$this->DataCustomString($post->specialites ,'spec') ; 
                

                /*the exists variable is  to check  the existance  of the post image  and  get its image from
                Postimages folder  because  the image name  will be  :  id_randomstr.jpg  */
                return view('user.'.$person.'.EditPost' , 
                    [
                            "specialites" => $specialites , 
                                 "post"   => $post ,
                                  "path"  =>  $pathToImage   ,
                         "KeywordsString" =>  $KeywordsString, 
                               "destinea" => $SpecialiteString,
                               "type"     => $person
                    ] );
        }
        else
        {
            $view['data']['msg'] = 'Il est maintenant impossible de mettre à jour un sujet ' ;
            return view ($view['page'] , $view['data'] ) ;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request  , $person , $id  )
    {
       
         $rules = 
        [
            'titre'          =>  'required|max:200' ,
            'domaine'        =>  'required', 
            'resume'         =>  'required|max:65000',
            'workplan'       =>  'required|max:65000',
            'photo'          =>  'mimes:jpeg,jpg,png'
        ] ;
       

        $request->flash(); // to flash the old inputs 
        $this->validate(request(),$rules);

        //Updating the Post 
        $post = Post::find($id) ;

        $post->titre         = $request->input('titre');
        $post->domaine       = $request->input('domaine');
        $post->resume        = $request->input('resume');
        $post->workplan      = $request->input('workplan');
        $post->oriente       = $request->input('oriente');
        $post->save();
        
        //Updating Keywords

        
        $keywords =  $post->keywords  ; 
        $post->keywords()->detach() ;
        /*After detaching a post from its keywords  checking  if the keyword has at least one post
         else delete it */
        foreach ($keywords as $keyword)
        {
            $hasAtLeastOnePost = Keyword::find($keyword->keyword)->posts->count()>0 ;
            if ( !$hasAtLeastOnePost )
            {
                    Keyword::find($keyword->keyword)->delete() ;
            }
          
        }


         $this->InsertingKeywords($post,$request->input('tags'));
         
        //Updating Specialites
        $post->specialites()->detach() ;
        $specialites = ( $request->input('destinea') ); 
        if(! empty($specialites) )
         {
            $post->specialites()->attach($specialites) ;
         }  

         //image save
         if ($request->hasFile('photo') && $request->file('photo')->isValid()) 
            {
                 

                //delete  the existing image
                File::delete ( glob(   'storage/Postimages/'.$id.'*.jpg')  );

                //for security
                $token = $this->randomString(20);

                $path = $request->photo->storeAs('Postimages', $id.$token.'.jpg', 'public');
                
            }


         return back()->with('status', 'Post Updated')->withInput([]); 


            


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request  , $person , $id)
    {
        if($request->ajax())
        {
            Post::find($id)->delete();
            return response()->json(['done' => $id]);
        }

    }

    protected function guard()
    {
       
        return Auth::guard($this->type );
    }

    public function InsertingKeywords($post,$tags)
    {
        if(!empty($tags) ) 
        {
                //retrieve keywords & save them 
                $tags = explode(',', $tags);
                
                foreach ($tags as $tag)
                { 

                    $result = Keyword::find($tag);

                    // if the keyword  does not exist in the table  Keyword   save it else  not save it of curse
                     if(is_null($result))
                     {
                            $keyword = new Keyword() ;
                            $keyword->keyword = $tag ;
                            $keyword->save() ;
                     }
                    
                                
                }

                $post->keywords()->attach($tags);
        }
    }


   



    

    public function DataCustomString ( $data ,$attribute )
    {
        $FinalString ="" ;
        foreach ($data   as $element)
      
         { 
             $FinalString = $FinalString . ($element->$attribute)."," ;
         }

        
        return  (substr($FinalString, 0 ,-1 ));
    }

    
}
