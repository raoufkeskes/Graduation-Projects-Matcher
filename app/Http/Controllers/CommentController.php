<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\User;

class CommentController extends Controller
{
	public function store(Request $request)
	{
		$comment = new Comment() ;
		$comment->post_id = $request->post_id ;
		$comment->user_id = $request->user_id ;
		$comment->comment = $request->content ;
		$comment->save() ;

		$user = User::find($request->user_id ) ;
		 //Commentator  photo 
	      $path = 'storage/Users/'.$user->userable_type."/".$user->id.'/ProfileImage/*.jpg' ;                 
	      $photoarray = glob($path) ; 
	      $bool = !empty($photoarray) ; 
		  $ShownComment['imagePath'] =  $bool  ?   $photoarray[0]    : "storage/Users/no-image.jpg" ;
            //DateTime Format for Comment
          $ShownComment['commentator'] = $user->userable_type != 'Company'
                  ? $user->userable->Nom.' '.$user->userable->Prenom
                  : $user->userable->Raison_sociale ;
              
            //DateTime Format for Comment
           setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //French
          
           $ShownComment['created'] = strftime('%d %B %Y à %H:%M' ,time() )    ;
           $ShownComment['content'] = $request->content ;
           $ShownComment['id'] = $comment->id ;




		return response()->json(['comment' => $ShownComment]);
	}

	public function delete(Request $request)
	{
		Comment::find($request->id)->delete() ;
		return response()->json([]);
	}
}
