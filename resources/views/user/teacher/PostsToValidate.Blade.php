@extends('user.layouts.MasterLayout')


@section('path')
   
   <li>Sujets à valider</li>

@stop

@section('Content')

@if(count($posts) == 0 )
                @include('errors.NoResults' , ['msg1' => "Aucune Sujet n'a été trouvé" , 'msg2' => "Malheureusement ! En ce moment L'administration ne vous a affecté aucun sujet" ])
@else

	<div class="row">



        
            
            
            <!-- END TIMELINE FILTER -->
           @foreach ($posts as $post)
                
                    <div class="panel panel-default" >
                        <div class="panel-body posts">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="post-item">
                                        <div class="post-title">
                                            <a href="/teacher/PostsTovalidate/{{$post->id}}" >{{$post->Titre}}</a>
                                            @if($post->Etat == 'Validé sous reserve')
                                            <div class="pull-right  sousReserve" style="color:#fe970a">
                                              Sous Réserve
                                            </div>
                                            @endif
                                        </div>
                                        <div class="post-date"><span class="fa fa-calendar"></span>
                                        Soumis le :{{$post->created}} / par
                                       
                                        {{$post->userposter->username}}
                                        
                                        <br>
                                        @if ($post->updated_at != $post->created_at )
                                            Dernière Modification : {{$post->updated}}
                                        @endif
                                         
                                         
                                        </div>
                                        

                                        <div class="post-text">   
                                                    @if ( !empty($post->imagePath) )
                                                        
                                                        <img src="/{{$post->imagePath}}" 
                                                    class="img-text post-image img-responsive"/>

                                                    @endif
                                                    
                                                    <p>
                                                        {{$post->Resume}}

                                                    </p>
                                        </div>

                                        <div class="post-row">
                                        
                                            <a href="/teacher/PostsTovalidate/{{$post->id}}" class="btn btn-default btn-rounded pull-right">Voir détails &RightArrow;</a>

                                        </div>
                                    </div>                                            
                                    
                                </div>
                            </div>

                            
                        </div>
                    </div>

            @endforeach
            
    </div>

    	<div class="modal" id="modal_basic" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                        <h4 class="modal-title" id="defModalHead">Etudiant</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                          <div id="StudentData" class="hidden">
                            <div class="personalStudentData">
                              <label                 class="col-md-6 col-xs-6  text-right">Nom :</label>
                              <label id="nom"        class="col-md-6 col-xs-6  ">NOM</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Prénom :</label>
                              <label id="prenom"     class="col-md-6 col-xs-6  ">PRENOM</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Matricule :</label>
                              <label id="matricule"  class="col-md-6 col-xs-6  ">MATRICULE</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Specialité :</label>
                              <label id="specialite" class="col-md-6 col-xs-6  ">SPECIALITE</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Email :</label>
                              <label id="email"      class="col-md-6 col-xs-6  ">EMAIL</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Etat :</label>
                              <label id="etat"      class="col-md-6 col-xs-6  ">monome</label>
                            </div>

                              <div class="col-md-12 col-xs-12">
                                      <fieldset class="moy">
                                          <legend>Cursus :</legend>
                                          <label         class="col-md-3 col-xs-6 text-right">1<sup>ère</sup> année:</label>
                                          <label id="L1" class="col-md-3 col-xs-6 "></label>
                                          <label         class="col-md-3 col-xs-6 text-right">2<sup>ème</sup> année:</label>
                                          <label id="L2" class="col-md-3 col-xs-6 "></label>
                                          <label         class="col-md-3 col-xs-6  text-right">3<sup>ème</sup> année:</label>
                                          <label id="L3" class="col-md-3 col-xs-6  "></label>
                                          <label         class="col-md-3 col-xs-6 text-right">Master 1:</label>
                                          <label id="M1" class="col-md-3 col-xs-6 "></label>
                                      </fieldset>
                              </div>
                              <div class="col-md-12 col-xs-12">
                                     <div class="gallery" id="links">
                                              
                                     </div> 
                              </div>
                          </div>

                          
                              <img  id="Loading" class="col-md-2 col-md-offset-5"  src="/img/ring.svg" alt="Loading ...">
                             
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
     	</div>


       <!-- BLUEIMP GALLERY -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>      
        <!-- END BLUEIMP GALLERY -->

@endif
@stop

@section('plugins scripts')
<!-- START THIS PAGE PLUGINS-->        
    	<script type="text/javascript" src="/User/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
        <script type="text/javascript" src="/User/js/raouf.js" ></script>
@stop 