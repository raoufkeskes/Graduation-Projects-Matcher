@extends('user.layouts.MasterLayout')

@php
    $type = strtolower(Auth::user() ->userable_type);
@endphp


@section('path')
   <li class="active">Mes Sujets Proposés</li>
@stop

@section('Content')
         <!-- START POSTS -->
        
                    
                    @if(count($posts) == 0 )
                        @include('errors.NoResults' , ['msg1' => "Aucune Sujet n'a été trouvé" , 'msg2' => "Malheureusement ! En ce moment aucun sujet porposé de votre part n'a été trouvé" ])
                    @else

                    <div class="row">

                        @foreach ($posts as $post)
                        
                            
                            
                            <div id="{{$post->id}}" class="panel panel-default" >
                                <div class="panel-body">
                                    <div  class="post-item" >
                                        <div class="post-title">
                                                <a class="buttonlink" href="/{{$type}}/posts/{{$post->id}}"><b>{{$post->Titre}}</b></a>
                                                @if($post->Etat == 'Validé sous reserve')
                                                <a class="pull-right sousReserve" style="color:#fe970a ; font-size: 20px ; font-weight: 400%" data-toggle="modal"  data-target="#modal_Reserve"  
                                                onClick="passarray({{json_encode($post['Reserves'])}})" >
                                                  Sous Réserve
                                                </a>
                                                @elseif($post->Etat == 'Validé')
                                                <div class="pull-right" style="color:#1f9641;
                                                font-size: 20px ;
                                                font-weight: 400%">
                                                  Accepté
                                                </div>
                                                @elseif($post->Etat == 'Refusé')
                                                <div class="pull-right" style="color:red ; font-size: 20px ; font-weight: 400%">
                                                  Refusé
                                                </div>
                                                @endif     
                                        </div>
                                        <div class="post-date"><span class="fa fa-calendar"></span>
                                            <b>Soumis le</b> :{{$post->created}} <Br>
                                            @if ($post->updated_at != $post->created_at )
                                                <b>Dernière Modification</b> : {{$post->updated}}
                                            @endif
                                         
                                        </div>
                                        <div class="post-text">
                                            
                                            <p>
                                            {{
                                                $post->Resume 

                                                }} 
                                            </p> 

                                            
                                                                                       
                                        </div>
                                        <div class="post-row">
                                            <div class="col-md-5 pull-right ">

                                                <div class="form-group">                                        
                                                    <div class="col-md-4">
                                                        <button class="delete btn btn-warning btn-block mb-control" data-id="{{$post->id}}"  data-box="#message-box-sound-1">
                                                        <span class="fa fa-trash-o"></span>Supprimer</button>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a class="buttonlink" href="/{{$type}}/posts/{{$post->id}}/edit" ><button class="btn btn-success btn-block"><span class="fa fa-edit"></span>
                                                        Modifier</button></a>
                                                    </div>              
                                                    <div class="col-md-4">
                                                        <a class="buttonlink" href="/{{$type}}/posts/{{$post->id}}"><button class="btn btn-info  btn-block">Voir Details &RightArrow;</button></a>
                                                    </div>              
                                                </div>

                                                    
                                            </div>
                                        </div>
                                    </div>
                              
                                </div>  
                            </div> 
                            


                        
                        @endforeach

                        

                    
                    </div>

                        
    <!-- END POSTS -->

    <!-- default with sound -->
            <div class="message-box animated fadeIn" data-sound="alert" id="message-box-sound-1">
                <div class="mb-container">
                    <div class="mb-middle">
                        <div class="mb-title"><span class="fa fa-globe"></span> Alert</div>
                        <div class="mb-content">
                            <p>Voulez vous supprimer ce sujet</p>
                            
                            <span class="deletedPost hidden"></span>                  
                        </div>
                        <div class="mb-footer">
                            
                            <div class="pull-right">
                                <button 
                                        id="deleteyes"
                                        
                                        class="btn btn-warning btn-lg  mb-control-close">
                                Oui</button>
                                <button class="btn btn-default btn-lg mb-control-close">Non</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    
    <div class="modal" id="modal_Reserve"  data-type="{{strtolower(Auth::user()->userable_type)}}" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                        <h4 class="modal-title" id="defModalHead">Réserve</h4>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word">
                        <ol>
                            
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
</div>
@endif
@stop

@section('plugins scripts')

<!-- START THIS PAGE PLUGINS-->      


        
        <script type="text/javascript" src="/User/js/raouf.js" ></script> 
                      
        

        <script type="text/javascript">

            $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                       });

            /* Remove Item */
            
            

            $(document).ready(function(){
                
                
                    

                  $('.delete').click(function()
                  {  

                      var id = $(this).data('id') ;
                      $('.deletedPost').text($(this).data('id'));   
                           
                      
                  }); 


                  $('#deleteyes').click(function(){  

                      var route = window.location.pathname+'/'  ; 
                      var id = $('.deletedPost').text() ;    
                      
                      
                        $.ajax({
                          dataType: 'json',
                          url: route+id,
                          type: 'post',
                           data: { 
                                    '_method' : 'delete'
                                 },
                          success: function(data){
                            
                           
                            $("#"+id).fadeOut(500, function() { $(this).remove() ;});
                          }
                        });
                        
                  }); 
            });

        </script>   
<!-- END THIS PAGE PLUGINS--> 

@stop  