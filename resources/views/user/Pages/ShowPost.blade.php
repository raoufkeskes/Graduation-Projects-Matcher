@extends('user.layouts.MasterLayout')

@section('path')
    @if (strpos(url()->previous(),'/posts')  !== false  )

        <li class="active">
                    <a href="/{{ strtolower(Auth::user()->userable_type) }}/posts"><span class="xn-text">Mes Sujets proposés</span></a>                        
        </li>
    @endif

   
    @if (strpos(url()->previous(),'/MentoredPosts')  !== false  )

        <li class="active">
                    <a href="/{{ strtolower(Auth::user()->userable_type) }}/{{Auth::user()->id}}/MentoredPosts"><span class="xn-text">Mes Sujets encadrés</span></a>                        
        </li>
    @endif


        <li>Voir les détails du sujet</li>


@stop

@section('Content')
	<div class="row">
                        <div class="col-md-9">
                            
                            <div class="panel panel-default">
                                <div class="panel-body posts">
                                            
                                    <div class="post-item">
                                        <div class="post-title">
                                            {{$post->Titre}}
                                        </div>
                                        <div class="post-date"><span class="fa fa-calendar"></span>
                                        Soumis le :{{$post->created}} / 
                                        @if ($post->CommentsNumber > 0 )
                                            <a href="#comments">{{$post->CommentsNumber}} Commentaires</a> 
                                        @else
                                            {{$post->CommentsNumber}} Commentaires
                                        @endif
                                        
                                        / <a href="pages-profile.html"> par 
                                            {{$post->userposter}}
                                        </a><br>
                                        @if ($post->updated_at != $post->created_at )
                                            Dernière Modification : {{$post->updated}}
                                        @endif
                                         
                                        </div>

                                        <div class="post-text">   
                                                    @if ( !empty($pathToImage) )
                                                        
                                                        <img src="/{{$pathToImage}}" 
                                                    class="img-text post-image img-responsive"/>

                                                    @endif
                                                    
                                                    <p>
                                                        {{$post->Resume}}

                                                    </p>
                                        </div>

                                        
                                    </div>      
                                                                      
                                

                                            
                                    
                                    <h3 id="comments" class="push-down-20">
                                        Commentaires
                                    </h3>
                                   
                                    <ul class="media-list">
                                    	
                                        
                                     	@foreach ($comments as $comment )
                                        <li class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object img-text" 
                                                src="/{{  $comment['imagePath']  }}" alt="" width="64">
                                            </a>
                                            @if(Auth::user()->id == $comment['commentator_id'] || 
                                                $post->poster_id == $comment['commentator_id'] )
                                            <a class="pull-right deleteComment" data-id="{{$comment->id}}" >Supprimer</a>
                                            @endif

                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                {{  $comment['commentator'] }}
                                                </h4>
                                                <p>{{  $comment->comment   }}</p>
                                                <p class="text-muted">{{  $comment['updated']  }}</p>
                                                                                                                                        
                                            </div>                                            
                                        </li>
                                        @endforeach
                                        <div class="addedComments">
                                            
                                        </div>

                                        @if( ! (Auth::user()->userable_type == 'Student') )
                                        <div class="comment-write" >                                                
                                                <textarea  id="comment-write" class="form-control" placeholder="Ecrire un Commentaire . . ." rows="3"></textarea>
                                                                                                
                                        </div>
                                        <br>
                                        <button data-userid="{{Auth::user()->id}}"  data-postid="{{$post->id}}" type="button" id="commentBtn" class="btn btn-default pull-right">Commenter</button>
                                        @endif

 
                                    
                                    </ul> 
                                    
                                    

                                   

                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-3">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3>Specialités visées</h3>
                                    <div class="links">
                                    @foreach ($specialites as $specialite)
                                    	<a  href="#">{{$specialite->spec}} <span class="label label-default">{{$specialite->niveau}}</span></a>
                                    @endforeach
                                        

                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3>Tags</h3>
                                    <ul class="list-tags push-up-10">
                                    @foreach ($keywords as $tag)
                                    	<li><a href="#"><span class="fa fa-tag"></span> {{$tag->keyword}}</a></li>
                                    @endforeach
                                        
                                    </ul>
                                </div>
                            </div>                            
                            
                        </div>
                    </div>
@stop

@section('plugins scripts')
     <script type="text/javascript" src="/User/js/raouf.js" ></script>
@stop