@extends('user.layouts.Masterlayout')

@php
	 $errorstab1 = old('username') || old('telephone') || old('raison_sociale') || old('matricule') || old('nom')  || 
	              old('prenom') || old('profession') ;

	  //passwords  no old Field
	 $errorstab2 = $errors->first('Mot_de_passe_courant') || $errors->first('Nouveau_mot_de_passe')
	 				|| $errors->first('Confirmation_du_nouveau_mot_de_passe') ;

	 $errorstab3 = old('1ere_année') || old('2eme_année') ||old('3eme_année') || old('Master_1') ;

	
	              
	$otherTabs  = $errorstab3 || $errorstab2|| session('status') == 'tab2' || session('status') == 'tab3' ;
	
	$activaTab1 = $errorstab1 ||  session('status') == 'tab1' || ! $otherTabs ;
	$activaTab2 = $errorstab2 ||  session('status') == 'tab2' ;
@endphp

 @section('path')
   <li class="active">Profil</li>
@stop

@section('Content')
<div class="row">

						

                        <div class="col-md-12">
                            
                           
                                                            
                                <div class="panel panel-default tabs">                            
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="{{$activaTab1 ? 'active' :''}}"><a href="#tab-first" role="tab" data-toggle="tab">Informations Personnelles</a></li>
                                        <li class="{{$activaTab2 ? 'active' :''}}"><a href="#tab-second" role="tab" data-toggle="tab">Mot de passe</a></li>
                                        @yield('CursusTab title')
                                        
                                    </ul>
	                                <div class="panel-body tab-content">
				                        
	                                   	<div class="tab-pane {{$activaTab1 ? 'active' :''}}" id="tab-first">
	                                   				@if($errorstab1)
			                                        	<div class="alert alert-danger col-md-12 {{count($errors)==0 ? 'hidden' :''}}" role="alert">
						                                <button type="button" class="close" data-dismiss="alert">
						                                        <span aria-hidden="true">&times;</span>
						                                        <span class="sr-only">Close</span>
						                                </button>
						                                <h3 class="errors">Erreurs !</h3>
						                                @foreach ($errors->all() as $error)
						                                    <strong> - {{$error}}</strong><br>
						                                @endforeach
						                                 
							                        	</div>
							                        @endif
							                        @if (session('status') == 'tab1')
							                        <div class="alert alert-success" role="alert">
							                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							                                <strong>Votre profil a été mis à jour avec Succès !</strong>
							                        </div>
							                        @endif	

		                                       	{!! Form::open(array('url'=>'/'.$type.'/'.$user->id.'/profile/update' , 'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}
		                                		
			                                        	
		                                			<div class="profilee">
							                            <div class="profilee-image">
							                                <img src="/{{$photo}}" class="blah img-responsive" alt="No image"/>
							                                <br>
							                                <input autocomplete="off" type="file" class="fileinput btn-primary text-center" name="photo"  title="Uploader une photo" accept=".jpg,.png" onchange="readURL(this);"
						                                    />
						                                    
							                            </div>
							                        </div>
		                            			
		                            				<div class="form-group">
						                                
						                                <div class="col-md-12">                                                                                  
						                                                                                         
						                                     <label class=" photolabel">Nouvelle photo de profil</label>
						                                    
						                                </div>
						                            </div>
		                                			
		                                            
		                                            
		                                            <div class="form-group">
		                                            
		                                                <label class="col-md-3 col-xs-12 control-label">Nom d'utilisateur</label>
		                                                <div class="col-md-6 col-xs-12">                                                                                                                                                        
		                                                    <input type="text" name="username" class="form-control" 
		                                                    value="{{   $errorstab1  ? old('username') : $user->username }}" required 
		                    								pattern="[a-zA-Z0-9-_]+{4,30}" title="Le Nom d'utilisateur doit contenir que des chiffres , des letteres et des tirets et il doit contenir au minimum 4 caractères"  autocomplete="off"/>                                                    
		                                                </div>
		                                            </div>

		                                            

		                                            @yield('DataName')

		                                            

		                                            <div class="form-group">
		                                                <label class="col-md-3 col-xs-12 control-label">Telephone</label>
		                                                <div class="col-md-6 col-xs-12">                                            
		                                                    <input type="text" class="form-control"  name ="telephone"  pattern="0\d{8,9}"  title="Exemple : 0555001122 / 021001122" 
		                                                    value="{{  $errorstab1 ? old('telephone') : $user->Telephone }}" autocomplete="off"/>
		                                                </div>
		                                            </div>
		                                            <div class="panel-footer">                                                                        
			                                        <button type="submit" class="btn btn-primary pull-right">Mettre à jour<span class="fa fa-floppy-o fa-right"></span></button>
			                                    	</div>
		                                        </form>
	                                        </div>

	                                        <div class="tab-pane {{$activaTab2 ? 'active' :''}}" id="tab-second">
		                                       		 
		                                       		 @if($errorstab2  )
			                                        	<div class="alert alert-danger col-md-12 {{count($errors)==0 ? 'hidden' :''}}" role="alert">
						                                <button type="button" class="close" data-dismiss="alert">
						                                        <span aria-hidden="true">&times;</span>
						                                        <span class="sr-only">Close</span>
						                                </button>
						                                <h3 class="errors">Erreurs !</h3>
						                                @foreach ($errors->all() as $error)
						                                    <strong> - {{$error}}</strong><br>
						                                @endforeach
						                                 
							                        	</div>
							                        @endif
							                        @if (session('status') == 'tab2')
							                        <div class="alert alert-success" role="alert">
							                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							                                <strong>Votre mot de passe a été modifié avec Succès !</strong>
							                        </div>
							                        @endif	
		                                				
		                                			<h3 class="text-center">Changement de mot passe</h3>
		                                			
		                                            <form class="form-horizontal" method="POST"
		                                            action="/{{$type}}/{{Auth::user()->id}}/resetPassword" >

		                                           	{{csrf_field()}}

		                                            <div class="form-group">
		                                            
		                                                <label class="col-md-3 col-xs-12 control-label">Mot de passe actuel</label>
		                                                <div class="col-md-6 col-xs-12">                                                                              
		                                                    <input type="password" name="Mot_de_passe_courant" class="form-control" 
		                                                    required />
		                    						                                                    
		                                                </div>
		                                            </div>

		                                            <div class="form-group">
		                                            
		                                                <label class="col-md-3 col-xs-12 control-label">Nouveau Mot de passe</label>
		                                                <div class="col-md-6 col-xs-12">                                                                              
		                                                    <input type="password" name="Nouveau_mot_de_passe" class="form-control" 
		                                                    required />
		                    						                                                    
		                                                </div>
		                                            </div>

		                                            <div class="form-group">
		                                            
		                                                <label class="col-md-3 col-xs-12 control-label">Retaper votre nouveau Mot de passe</label>
		                                                <div class="col-md-6 col-xs-12">                                                                              
		                                                    <input type="password" 
		                                                    name="Confirmation_du_nouveau_mot_de_passe" 
		                                                    class="form-control" 
		                                                    required />
		                    						                                                    
		                                                </div>
		                                            </div>


                                                                        
			                                        <button type="submit" name="pass" class="btn btn-primary pull-right">Mettre à jour<span class="fa fa-floppy-o fa-right"></span></button>
			                                    	</form>

		                                        
	                                        </div>
	                                    
	                                    	

	                                    
	                                        @yield('CursusTab')                                       
                                        
                                    </div>


                                    
                                </div>                                
                            
                           
                            
                        </div>
</div> 
@stop


@section('plugins scripts')

<!-- START THIS PAGE PLUGINS-->      
		 
		
        <script type="text/javascript" src="/User/js/plugins/bootstrap/bootstrap-select.js"></script>
      	<script type="text/javascript" src="/User/js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="/User/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="/User/js/raouf.js"></script>
<!-- END THIS PAGE PLUGINS--> 


@stop 