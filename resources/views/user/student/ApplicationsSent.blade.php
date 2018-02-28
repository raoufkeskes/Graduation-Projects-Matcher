@extends('user.layouts.MasterLayout')

@section('path')
   <li>Demandes</li>
   <li class="active" >Postulations Envoyées</li>
@stop

@section('Content') 

<div class="row">
    <div class="col-md-12">
    		
    		
            

            <div class="panel panel-default">                                
                <div class="panel-body">
                   
                    <h3>Postulations Envoyées</h3>
                    <div class="alert alert-warning" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <strong>Note !</strong><br>Une suppression automatique sera faite pour les postulations non retenues par le destinataire, et cela implique leur non figuration dans la liste ci-dessous.
                                

                    </div>
                    
                    @if ( count($posts)>0 )
                            
                    
                    <div id="MasterDiv">
                    <div class="row" >
                    	<div class="col-md-12">
                    		<div class="panel-body list-group list-group-contacts List">  
                                
                                    {{-- expr --}}
                                 
                                    @foreach ($posts as $post)
                                    <div  id="{{$post->id}}" class="list-group-item col-md-12">                                 
                                        <div class="pull-left">
                                        
                                        <span class="contacts-title"><a href="/student/posts/{{$post->id}}">{{$post->Titre}}</a></span>
                                        </div>        
                                        <div class="pull-right"> 
                                            <button  name="refuse"  data-postid="{{$post->id}}" 
                                        data-studentid="{{Auth::user()->id}}" class="btn btn-danger custom                    annulePostulation">
                                                 Annuler
                                            </button>
                                        
                                        </div>     

                                    </div>
                                    <Br>
                                    @endforeach  

                                



                                                      
                                    
                            </div>
                    		
                    	</div>
                    	
                    </div>
                    
                    </div>

                    @endif

                </div>
            </div>
            @if ( count($posts)==0 )
                            @include('errors.NoResults' , ['msg1' => "Aucune Postulation n'a été trouvée" , 'msg2' => "Malheureusement ! En ce moment Vous n'avez aucune postulation envoyée en attente" ])
            @endif
           
    </div>
</div>

@stop




@section('plugins scripts')

<!-- START THIS PAGE PLUGINS-->        
         <script type="text/javascript" src="/User/js/raouf.js" ></script>
         

@stop 