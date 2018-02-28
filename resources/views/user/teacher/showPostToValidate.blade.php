 @extends('user.layouts.MasterLayout')



@section('path')
    @if (strpos(url()->previous(),'/PostsTovalidate')  !== false  )

        <li class="active">
                    <a href="/{{ strtolower(Auth::user()->userable_type) }}/{{Auth::user()->id}}/PostsTovalidate"><span class="xn-text">Sujets à valider</span></a>                        
        </li>

    @endif
    
    <li>Voir les détails du sujet</li>
@stop

 @section('Content')
   <div class="row">
                        <div class="col-md-12">
                            
                            @if (session('status') == 'good')
                            <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <strong>{{session('msg')}}</strong>
                                    <a class="buttonlink  col-md-2 pull-right" href="/teacher/{{Auth::user()->id}}/PostsTovalidate" ><button class="btn btn-default btn-block"><span class="fa fa-edit"></span>
                                    Sujets â valider </button></a>
                            </div>
                            @endif
                            @if(session('status') == 'bad')
                            <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <strong>{{session('msg')}}</strong> 
                                    <a class="buttonlink  col-md-2 pull-right" href="/teacher/{{Auth::user()->id}}/PostsTovalidate" ><button class="btn btn-default btn-block"><span class="fa fa-edit"></span>
                                    Sujets â valider </button></a>
                            </div>
                            @endif
                                <div class="panel-body posts">
                                            
                                    <div class="post-item">
                                        <div class="post-title">
                                            {{$post->Titre}}
                                        </div>
                                        <div class="post-date"><span class="fa fa-calendar"></span>
                                            Soumis le :{{$post->created}} /
                                             
                                             par 
                                                {{$post->userposter->username}}
                                            <br>
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

                                    <div class="row">
                                            <div class="col-md-12">
                                                
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <h3 class="push-down-0">Informations</h3>
                                                    </div>
                                                    <div class="panel-body faq">
                                                        
                                                        <div class="faq-item">
                                                            <div class="faq-title"><span class="fa fa-angle-down"></span>Specialités visées</div>
                                                            <div class="faq-text ">
                                                                
                                                                <div class="links">

                                                                    @foreach ($specialites as $specialite)
                                                                    
                                                                      <a href="#">{{$specialite->spec}} ({{$specialite->label}})<span class="label label-default">{{$specialite->niveau}}</span></a>
                                                                    
                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                        </div>


                                                        
                                                        <div class="faq-item">
                                                            <div class="faq-title"><span class="fa fa-angle-down"></span>Plan de Travail</div>
                                                            <div class="faq-text ">
                                                                <p>
                                                                    {{$post->Workplan}}
                                                                </p>
                                                            </div>
                                                        </div>  
                                                           
                                                        
                                                        
                                                        
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                            </div>                              
                                    </div>
                                    
                                    
                                    @if( session('except') == 'reserve' ||  $post['display'] )
                                    <div class="panel-body">
                                        
                                                                                                                    
                                            <div class="form-group col-md-8  col-md-offset-2">                                        
                                                <div class="col-md-4">
                                                    <button class="btn btn-success btn-lg btn-block mb-control" data-box="#message-box-success" >Valider</button>
                                                </div>

                                                <div class="col-md-4">
                                                    <button class="btn btn-warning btn-lg btn-block "
                                                    data-toggle="collapse" data-target="#Reserve"  >Valider sous Réserve
                                                    </button>

                                                </div>              
                                                <div class="col-md-4">
                                                    <button class="btn btn-danger btn-lg btn-block mb-control" 
                                                    data-box="#message-box-danger" >Refuser</button>
                                                </div>  

                                            </div>  

                                             

                                            <div  id="Reserve" class="collapse panel panel-default">
                                                <div class="panel-heading ui-draggable-handle">
                                                    <h3 class="panel-title">Reserve</h3>
                                                    <ul class="panel-controls">
                                                        
                                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                                    </ul>
                                                </div>
                                                <form method="POST" action="/teacher/posts/{{$post->id}}/validerSousReserve" >
                                                <input hidden type="text" name="user_id" value="{{Auth::user()->id}}">
                                                {{csrf_field()}}
                                                <div class="panel-body">
                                                
                                                    <div class="form-group">
                                                      <textarea name="Reserve" required class="form-control" rows="5">{{$post->reserve}}</textarea>
                                                      <input hidden type="text" name="user_id" 
                                                      value="{{Auth::user()->id}}">
                                                    </div>
                                                </div>      
                                                <div class="panel-footer">
                                                    <button  type="submit" class="btn btn-primary pull-right">Valider mon choix</button>
                                                </div> 
                                                </form> 
                                            </div>  

                                    </div>   
                                    @endif
                                                                        
 
                                </div>
                            </div>    
                        </div>

                        
   </div>

   <!-- Message Boxes -->   

   <!-- success -->
        <div class="message-box message-box-success animated fadeIn" id="message-box-success">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-check"></span> Validation !</div>
                    <div class="mb-content">
                        <p>Vous êtes sur le point de valider ce sujet </p>
                        <p>Aucune autre modification de votre choix ne sera permise</p>
                    </div>
                    <form method="POST" action="/teacher/posts/{{$post->id}}/valider">
                    <input hidden type="text" name="user_id"  value="{{Auth::user()->id}}">
                        <div class="mb-footer">
                            
                             <div class="pull-right">
                             
                                {{csrf_field()}}
                                <button id="YesRefuser" type="submit"  class="btn btn-success btn-lg">Oui</button>     
                            
                                
                                <button class="btn btn-default btn-lg mb-control-close">Non</button>
                             </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end success -->
        
       
        
        
        
        <!-- danger -->
        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span>Refus !</div>
                    <div class="mb-content">
                        <p>Vous êtes sur le point de refuser ce sujet </p>
                        <p>Aucune autre modification de votre choix ne sera permise</p>
                    </div>
                    <form method="POST" action="/teacher/posts/{{$post->id}}/refuser">
                    <input hidden type="text" name="user_id"  value="{{Auth::user()->id}}">
                        <div class="mb-footer">
                            
                             <div class="pull-right">
                             
                                {{csrf_field()}}
                                <button id="YesRefuser" type="submit"  class="btn btn-danger btn-lg">Oui</button>     
                            
                                
                                <button class="btn btn-default btn-lg mb-control-close">Non</button>
                             </div>
                        </div>
                    </form>

                    
                </div>
            </div>
        </div>
        <!-- end danger -->
        
        <!-- END Message Boxes -->



 @stop  

@section('plugins scripts')
            
         <script type="text/javascript" src="/User/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
         <script type="text/javascript" src="/User/js/faq.js"></script>
         <script type="text/javascript" src="/User/js/raouf.js" ></script>
@stop 
   







