@extends('user.layouts.MasterLayout')




@section('path')
   <li class="active">Acceuil</li>
@stop

@section('Content')
	<div class="row">



        
           
            <!-- START TIMELINE FILTER -->                            
            <div class="panel panel-default">                                
                <div class="panel-body">
                    
                    <h3>Filtre de Recherche</h3>

                    <form class="form-horizontal"   method="GET" action="/{{$type}}/home/search">
                    <div class="form-group">
                                                              
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                <input name="keywords" type="text" class="form-control search-field" id="searchBox" autoFocus placeholder="Mots clés" autocomplete="off" value="{{old('keywords')}}" />
                                <ul id="searchResults" class="term-list hidden"></ul>

                            </div>
                        </div>  


                        <div class="col-md-2">
                                
                                <button type="submit" class="btn btn-info btn-block" name="search" value="search"
                                data-toggle="tooltip" data-placement="top" title="Recherche avec mot-clés seulement">
                                     <span class="fa fa-search" ></span>Rechercher
                                </button>
                         


                                

                        
                        </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info btn-block" name="advancedSearch" value="advancedSearch"
                                data-toggle="tooltip" data-placement="top" title="Recherche avec mot-clés et filtres de recherche">
                                <span class="fa fa-search-plus"></span>Recherche avancée
                                </button>
                            </div>                                        
         
                    
                    </div>
                    

                    <div class="form-group">
                    
                        <div class="col-md-3">                                                                                
                            <select class="form-control select"  name="specialite" data-content="{{ old('specialite') }}" >
                                <option  selected >Toutes les Specialités</option>
                                <optgroup label="Licence">
                                @foreach ($specialites['Licence'] as $specialite)
                                    <option  >{{$specialite->spec}}</option>
                                @endforeach
                                </optgroup>

                                <optgroup label="Master">
                                @foreach ($specialites['Master'] as $specialite)
                                    <option  >{{$specialite->spec}}</option>
                                @endforeach
                                </optgroup>
                            </select>

                        </div>

            

                        <div class="col-md-3">                                                                                
                            <select class="form-control select"  name="domaine" data-content="{{ old('domaine')}}">
                                <option  selected >Tout les domaines</option>
                                <option>Génie Logiciel, Système d’Information et Base de Données</option>
                                <option>Réseaux Sécurité, Réseaux Mobiles et Système d’Exploitation</option>
                                <option>Intelligence Artificielle et Méta Heuristiques</option>
                                <option>Développement Web et Mobile</option>
                                <option>Architecture</option>
                                <option>Vision et Imagerie</option>
                                <option>Informatique Théorique</option>
                            </select>

                        </div>
                        
                        <div class="col-md-3">                                                                                
                            <select class="form-control select" name="oriente" data-content="{{ old('oriente') }}" >
                                <option selected>Orienté</option>
                                <option>Recherche & Pratique</option>
                                <option>Recherche</option>
                                <option>Pratique</option>      
                            </select>

                        </div>

                        <div class="col-md-3">                                                                                
                            <select class="form-control select" name="order"  data-content="{{ old('order') }}">
                                <option  selected >Date</option>
                                <option>Plus récents</option>
                                <option>Plus anciens</option>      
                            </select>

                        </div>

                    </div>
                    
                    </form>
                </div>
            </div>
             @if(count($posts) == 0 )
                @include('errors.NoResults' , ['msg1' => "Aucune Sujet n'a été trouvé" , 'msg2' => "Malheureusement ! En ce moment aucun sujet n'est disponible" ])
            @else
            <!-- END TIMELINE FILTER -->
           @foreach ($posts as $post)
                
                    <div class="{{$post->poster->id}} panel panel-default" data-postid="{{$post->id}}" >
                        <div class="panel-body posts">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="post-item">
                                        <div class="post-title">
                                            <a href="/{{$type}}/posts/{{$post->id}}">{{$post->Titre}}</a>
                                        </div>
                                        <div class="post-date"><span class="fa fa-calendar"></span>
                                        Soumis le :{{$post->created}} / 
                                        @if ( $post->comments_count > 0 )
                                        <a href="/{{$type}}/posts/{{$post->id}}#comments">{{$post->comments_count}} Commentaires</a> 
                                        @else
                                            {{$post->comments_count}} Commentaires
                                        @endif
                                        / par
                                        @if(Auth::user()->userable_type != 'Student')

                                        <a data-userid="{{$post->poster->id}}"  data-toggle="modal"  data-target="#modal_basic" >
                                        
                                        {{$post->poster->username}}
                                        </a>
                                        
                                        @else
                                        {{$post->poster->username}}
                                        @endif
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
                                        
                                            <a href="/{{$type}}/posts/{{$post->id}}" class="btn btn-default btn-rounded pull-right">Voir détails &RightArrow;</a>
                                            
                                            @if(Auth::user()->userable_type == 'Student')
                                                <button type="button"  data-postid="{{$post->id}}" data-userid="{{Auth::user()->id}}"
                                                class="postuler btn btn-success btn-rounded
                                                {{$post->activate ? 'active' : ''}} ">
                                                @if($post->activate)
                                                <span class="fa fa-check-circle"></span> Déjà Postulé
                                                @else
                                                <span class="fa fa-star"></span>Postuler</button>
                                                @endif
                                            @else
                                                <button type="button"  data-postid="{{$post->id}}" 
                                                data-userid="{{Auth::user()->id}}"   data-studentid ="{{$post->poster->id}}"
                                                 class="Encadrer btn btn-success btn-rounded mb-control
                                             
                                                 {{$post->activate ? 'active' : ''}} "
                                                 data-box="#mb-encadrer">
                                                @if($post->activate)
                                                <span class="fa fa-check-circle"></span> Déjà Encadré
                                                @else
                                                <span class="fa fa-star"></span>Encadrer</button>
                                                @endif
                                            @endif
                                            

                                        </div>
                                    </div>                                            
                                    
                                </div>
                            </div>

                            
                        </div>
                    </div>

            @endforeach
            @endif
            
    </div>
        
            
    @if( ! count($posts) == 0 )

     <div class="message-box animated fadeIn"  id="mb-encadrer">
            <div id="companypromoteur" class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-user-circle"></span> <strong>Promoteur</strong> ?</div>
                    <div class="mb-content">
                        <p id="question">Êtes-vous sûr de bien vouloir être le promoteur de ce sujet ?</p>
                        

                           
                           @if(Auth::user()->userable_type =='Company')
                           <form id="form1" class="form-horizontal">
                               
                               <br>
                                   <p class="text-center">Informations sur l'encadreur(Obligatoire)</p>

                                   
                                   <div class="form-group text-center">
                                            <label class="control-label">Employé Existant déjà ?</label>
                                            <div class="">
                                                <label class="switch switch-small">
                                                    <input id="checkbox1" name="EmployeExist" type="checkbox" value="0"/>
                                                    <span></span>
                                                </label>
                                            </div>
                                    </div>
                                   
                               <br>
                                                    
                                                    
                                                    <div id="newEmploye">
                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Nom :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="nom" class="form-control" 
                                                             />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Prénom :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="prenom" class="form-control"
                                                             
                                                            required />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Service :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="service" class="form-control" 
                                                              required />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Grade :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="grade" class="form-control" 
                                                            required    />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Profession :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="profession" class="form-control" 
                                                            required   />
                                                                                                        
                                                        </div>
                                                    </div> 
                                                    </div>

                                                    <div id="oldEmploye" class="form-group hidden">
                                                            <label class="col-md-3 control-label">Vos encadreurs</label>
                                                            <div class="col-md-6">

                                                                        <select id="selectEmployee" class="form-control select" data-live-search="true">
                                                                            <option value="0">Aucun</option>
                                                                            @foreach ($employes as $employe)
                                                                                <option value="{{$employe->id}}">{{$employe->Nom.' '.$employe->Prenom}}</option>
                                                                            @endforeach
                                                                            
                                                                            
                                                                        </select>
                                                                    </div>
                                                     </div>
                                
                                                       


                           </form>
                           @endif

                            <div class="mb-footer">

                                                            <div class="pull-right">
                                                                <button id="YesEncadrer" 
                                                                
                                                                data-type="{{strtolower(Auth::user()->userable_type)}}"
                                                                class="btn btn-success btn-lg"
                                                                >Oui</button>
                                                                <button class="btn btn-default btn-lg mb-control-close">Non</button>
                                                            </div>
                                                            
                                                            
                                                            
                            </div>

                            
                            
                       
                    </div>
                    
                </div>
            </div>
     </div>


         <div class="modal" id="modal_basic"  data-type="{{strtolower(Auth::user()->userable_type)}}" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
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
        
        <script type="text/javascript" src="/User/js/plugins/bootstrap/bootstrap-select.js"></script>   
         <script type="text/javascript" src="/User/js/autocompletebyraouf.js" ></script>    
         
         <script type='text/javascript' src='/User/js/plugins/noty/jquery.noty.js'></script>
         <script type='text/javascript' src='/User/js/plugins/noty/layouts/topCenter.js'></script>
         <script type='text/javascript' src='/User/js/plugins/noty/themes/default.js'></script>
         <script type='text/javascript' src="/User/js/plugins/jquery-validation/jquery.validate.js"></script>
         <script type="text/javascript" src="/User/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
         <script type="text/javascript" src="/User/js/raouf.js" ></script>
         <script type="text/javascript" src="/User/js/FormValidationraouf.js"></script>


<script type="text/javascript">
            $( "select" ).each(function(  ) {
                 $(this).val($(this).data('content'))  ;
            });
</script>
         
         
 

@stop 