@extends('user.layouts.MasterLayout')

@section('path')
   <li>Demandes</li>
   <li class="active" >Demandes de Binôme</li>
@stop

@section('Content') 

<div class="row">
    <div class="col-md-12">
    		
    		@if($Binome)
    		<div class="panel panel-default Binome">                                
                <div class="panel-body ">
                	 <p class="binome text-center">
                	 	Vous êtes Binôme <br>avec  {{$Binome->Nom.' '.$Binome->Prenom}}
                	 	<br>
                	 	<div>
                	 	  <div class="help text-center">Si vous voulez l'annuler cliquez  sur le bouton ci-dessus</div>
                	 		<br>
                	 	<form method="POST" action="/student/{{Auth::user()->id}}/RemoveBinome">
                	 	 {{ csrf_field()}}
                	 	  <button type="submit"  class="btn btn-danger col-md-4 col-md-offset-4 btn-lg">Redevenir Monôme</button>
                	 	 
                	 	  
                	 	</form>
                	 	</div>

                	 </p>
                </div>
            </div>
            @else
            <div class="panel panel-default">                                
                <div class="panel-body">
                
                    <h3>Introduisez un matricule</h3>

                    
                    <div class="form-group">
                                                              
                        <div class="col-md-10">
                                      
                                <input name="matricule" type="text" class="form-control col-md-10" 
                                autoFocus placeholder="Matricule   Exemple:201700001111" autocomplete="off" />
                                                            
                        </div>  


                        <div class="col-md-2">
                                
                            <button id="Binome" class="btn btn-info btn-block" data-userid = "{{Auth::user()->id}}" >
                                    Envoyer ma demande  <span class="fa fa-arrow-right"  ></span>
                            </button>
                        </div>

                    </div>
                	
                </div>
            </div>

            <div class="panel panel-default">                                
                <div class="panel-body">
                   
                    <h3>Demandes de binôme reçues</h3>
                    <div id="MasterDiv">
                    @if (count($BinomeRequesters)>0 )
                    <div class="row" >
                    	<div class="col-md-12">
                    		<div class="panel-body list-group list-group-contacts List">  
                                
                                    {{-- expr --}}
                                 
                                    @foreach ($BinomeRequesters as $BinomeRequester)
                                    <div  id="{{$BinomeRequester->id}}" class="list-group-item col-md-12">                                 
                                        <div class="col-md-8">
                                        <img src="/{{$BinomeRequester->imagePath}}"
                                         class="pull-left" alt="ni image"/>
                                        <span class="contacts-title">{{$BinomeRequester->Nom}} {{$BinomeRequester->Prenom}}</span>
                                        <p>Matricule : {{$BinomeRequester->Matricule}}</p>
                                        </div>        
                                        <div class="col-md-4">                                                             
                                        <div  class="list-group-controls" data-userid="{{Auth::user()->id}}" 
                                        data-studentid="{{$BinomeRequester->id}}" >

                                            <button  name="accept" class="btn btn-success custom">
                                                 Accepter
                                            </button>
                                            <button  name="refuse" class="btn btn-danger custom">
                                                 Refuser
                                            </button>
                                        </div>
                                        </div>     

                                    </div>
                                    @endforeach  

                                



                                                      
                                    
                            </div>
                    		
                    	</div>
                    	
                    </div>
                    
                    @endif 
                    </div>

                </div>
            </div>

            @if ( count($BinomeRequesters)==0 )
                            @include('errors.NoResults' , ['msg1' => "Aucune Demande n'a été trouvée" , 'msg2' => "Malheureusement ! En ce moment aucune demande de binôme ne vous a été envoyée" ])
            @endif
            @endif
    </div>
</div>

@stop




@section('plugins scripts')

<!-- START THIS PAGE PLUGINS-->        
        
          
         
         <script type='text/javascript' src='/User/js/plugins/noty/jquery.noty.js'></script>
         <script type='text/javascript' src='/User/js/plugins/noty/layouts/topCenter.js'></script>
         <script type='text/javascript' src='/User/js/plugins/noty/themes/default.js'></script>
         
         <script type="text/javascript" src="/User/js/raouf.js" ></script>
         
         
 

@stop 