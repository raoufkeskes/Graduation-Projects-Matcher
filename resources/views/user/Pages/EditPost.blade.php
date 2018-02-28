@extends('user.layouts.MasterLayout')


@php
       
        $errorsYes =  count($errors) > 0  ;

                                    
@endphp


@section('path')
   
   <li ><a href="/{{$type}}/posts">Mes Sujets Proposés</a></li>
   <li class="active">Modifier un Sujet</li>

   

   
@stop

@section('Content') 




<div class="row">
    <div class="col-md-12">
        
        
        {!! Form::open(array('url'=>'/'.$type.'/posts'.'/'.$post->id, 'class'=>'form-horizontal','method'=>'POST', 'files'=>true)) !!}

            {{ method_field('PATCH') }}



            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title-centered"><strong>Modifier un Sujet</strong></h3>
                    
                </div>

               
                <div class="panel-body">                                                                        
                    
                    <div class="row">

                        
                           
                        
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
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong>Votre sujet a été modifié avec Succès!</strong>
                        </div>

                        
                            
                       
                        @endif

                        
                                             
                            
                        <div class="col-md-6">
                            
                            

                            <div class="form-group">
                                <label class="col-md-3 control-label">Titre</label>
                                <div class="col-md-9">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input required autocomplete="off" type="text" name="titre" class="form-control"
                                        value="{{  $errorsYes ? (old('titre') ) : $post->Titre }}" />
                                    </div>                                            
                                    <span class="help-block">Ce champs est obligatoire</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Domaine</label>
                                <div class="col-md-9">

                                    <select class="form-control select"  name="domaine" id="selectdomaine" 
                                    title="Selectionner Un Domaine" data-domaine="{{$post->Domaine}}"
                                    data-old="{{old('domaine')}}" >
                                    
                                    		<option  data-hidden="true"></option>
                                        	<option>Génie Logiciel, Système d’Information et Base de Données</option>
                                            <option>Réseaux Sécurité, Réseaux Mobiles et Système d’Exploitation</option>
                                            <option>Intelligence Artificielle et Méta Heuristiques</option>
                                            <option>Développement Web et Mobile</option>
                                            <option>Architecture</option>
                                            <option>Vision et Imagerie</option>
                                            <option>Informatique Théorique</option>
                                    </select>
                                    <span class="help-block">Vous devez selectionner un domaine</span>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Orienté</label>
                                <div class="col-md-9">                                                                                            
                                    <select data-oriente="{{$post->Oriente}}" class="form-control select" id="oriente" name="oriente" data-old="{{old('oriente')}}" >
                                            <option selected >Recherche & Pratique</option>
                                            <option>Recherche</option>
                                            <option>Pratique</option>
                                    </select>
                                    <span class="help-block">Ce champs n'est pas obligatoire</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Résumé</label>
                                <div class="col-md-9 col-xs-12">                                            
                                    <textarea  required name="resume" class="form-control" rows="10"
                                    >{{ $errorsYes  ? (old('resume') ) : $post->Resume}}</textarea>
                                    <span class="help-block">le Contenu de votre projet et vos objectifs</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Plan de travail</label>
                                <div class="col-md-9 col-xs-12">                                            
                                    <textarea required name="workplan" class="form-control" rows="5"
                                    >{{ $errorsYes ? (old('workplan') ) : $post->Workplan}}</textarea>
                                    <span class="help-block">Ce champs est obligatoire</span>
                                </div>
                            </div>


                            
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Bibliographie</label>
                                <div class="col-md-9 col-xs-12">                                            
                                    <textarea class="form-control" rows="5" name="bibliographie"
                                    >{{$errorsYes ? (old('bibliographie') ) : $post->Bibliographie}}</textarea>
                                    <span class="help-block">Ce champs n'est pas obligatoire</span>
                                </div>
                            </div>
                            
                            

                            @yield('additionnalstuff')



                            <div class="form-group">
                                <label class="col-md-3 control-label">Mots-clés</label>
                                <div class="col-md-9">
                                    <input autocomplete="off" type="text" class="tagsinput"  name="tags" id="tags" 
                                    value="{{$errorsYes ? old('tags')  : $KeywordsString}}" 
                                     />
                                    
                                    <span class="help-block">Les mots-clés facilitent la recherche</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nouvelle Image</label>
                                <div class="col-md-9">                                                                                  
                                                                                         
                                    <input autocomplete="off" type="file" class="fileinput btn-primary" name="photo"  title="Uploader une image" accept=".jpg,.png" onchange="readURL(this);"
                                    />
                                    <span class="help-block">uploader une image/photo illustrant votre projet</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Image</label>
                                <div class="col-md-9"> 
                                
                                     <div class="gallery" id="links">
                            
                                            <a class="gallery-item imagePostEdit" href="/{{$path}}" data-gallery>
                                                <div class="image">                              
                                                    <img  class="blah " src="/{{$path}}" alt="Pas d'image"
                                                       />
                                                </div>
                                            </a>

                                            
                                             
                                    </div>
                                


                                    <span class="help-block">La photo actuelle illustrant votre projet</span>
                                </div>
                            </div>

                            


                            

                           
                            
                            
                            
                        </div>
                        
                    </div>

                </div>
                <div class="panel-footer">
                                                        
                    <button type="submit" class="btn btn-primary col-md-2 pull-right">Mettre à jour</button>
                    <button id="vider" type="reset" class="btn btn-info">Vider tout les champs</button>

                </div>

            </div>

            
        </form>


       
        
    </div>
</div> 




                
                                   
                
     
        
        <!-- BLUEIMP GALLERY -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>      
        <!-- END BLUEIMP GALLERY -->
        
        

        
    <!-- END SCRIPTS -->         

@stop  



@section('plugins scripts')

<!-- START THIS PAGE PLUGINS-->        
    	<script type='text/javascript' src='/User/js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="/User/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="/User/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
        <script type="text/javascript" src="/User/js/plugins/bootstrap/bootstrap-select.js"></script>   
        <script type="text/javascript" src="/User/js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="/User/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="/User/js/FullScreenLinks.js" ></script> 
        <script type="text/javascript"  src="/User/js/raouf.js" ></script>  
        <script type="text/javascript"  src="/User/js/createpost.js"></script>

@stop  
