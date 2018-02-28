<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Test</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="/User/favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="/User/css/theme-default.css"/>

         <!-- START PLUGINS -->
        <script type="text/javascript" src="/User/js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/User/js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/User/js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->
        
  

        <!-- EOF CSS INCLUDE -->                                    
    </head>

    @php
            
            setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
            $user = Auth::user() ;
            $Notifications = (  $user->Notifications()->latest()->limit(10)->get() ) ;
            $count = $user->Notifications()->where('is_New',1)->count() ;
            //user profile photo 
                  $path = 'storage/Users/'.$user->userable_type."/".$user->id.'/ProfileImage/*.jpg' ;
                  $photoarray = glob($path) ; 
                  $bool = !empty($photoarray) ; 
                  $photo =  $bool  ?   $photoarray[0]    : "storage/Users/no-image.jpg" ; 

            
            // to determine user type 
            $type = strtolower($user->userable_type);
            $typefr = ($type === 'student') ? 'Etudiant' : ( ($type === 'teacher') ?'Enseignant': 'Entreprise') ;

            //display name/family-name   or  raison_sociale
            
            $dataname =  $user->userable_type == "Company" ? $user->userable->Raison_sociale : 
                         $user->userable->Nom.' '.$user->userable->Prenom ; 


           
        @endphp
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">

                        <a href="/{{$type}}/home">{{$typefr}}</a>
                        <a href="/User/#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="/{{$type}}/home" class="profile-mini">
                            <img src="/{{$photo}}" alt="No image"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="/{{$photo}}" alt="No image"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">{{$dataname}}</div>
                                <div class="profile-data-title">{{$user->username}}</div>
                            </div>
                            <div class="profile-controls">
                                <a href="/{{$type}}/{{Auth::user()->id}}/profile" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="/User/pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                            </div>
                        </div>                                                                        
                    </li>
                    
                    <!-- check if it s the home  to activate the link -->
                    <li class="{{ Request::is('*/home') ? 'active' : '' }}">
                        <a href="/{{$type}}/home"><span class="fa fa-desktop"></span>
                            <span class="xn-text">Acceuil</span>
                        </a>                        
                    </li>    
                    <li class="{{Request::is('*/profile') ? 'active' : '' }}">
                        <a href="/{{$type}}/{{Auth::user()->id}}/profile"><span class="fa fa-user"></span> <span class="xn-text">Profil</span></a>
                    </li>
                    {{--<li class="xn-openable">
                                <a href="#"><span class="fa fa-envelope"></span> <span class="xn-text">Messagerie</span></a>
                                <ul>
                                    <li><a href="/User/pages-mailbox-inbox.html"><span class="fa fa-inbox"></span>Boîte de réception</a></li>
                                    <li><a href="/User/pages-mailbox-compose.html"><span class="fa fa-comments-o"></span> Nouveau Message</a></li>
                                </ul>
                    </li>--}}
                    <li class="{{ Request::is('*/posts/create') ? 'active' : '' }}">
                        <a href="/{{$type}}/posts/create"><span class="fa fa-pencil"></span> <span class="xn-text">Proposer un sujet</span></a>
                    </li> 
                    @if($type == 'student')
                    <li class="{{ Request::is('*/posts') ? 'active' : '' }}" >
                        <a href="/{{$type}}/posts"><span class="fa fa-files-o"></span> <span class="xn-text">Mes sujets proposés</span></a>
                    </li>  
                         

                    
                    <li class="xn-openable  {{ Request::is('*/Binome') ? 'active' : '' }}">
                                <a><span class="fa fa-files-o"></span> <span class="xn-text">Demandes</span></a>
                                <ul>
                                   
                                        <li  class="{{ Request::is('*/Binome') ? 'active' : '' }}" >
                                            <a href="/student/{{Auth::user()->id}}/Binome">
                                            <span class="glyphicon glyphicon-user"></span>
                                            Demandes de Binôme</a>
                                        </li>
                                        <li><a href="/student/{{Auth::user()->id}}/MyApplications"><span class="fa fa-paper-plane"></span>Postulations Envoyées</a></li>
                                   
                                   
                                </ul>
                    </li>
                    @else
                    <li >
                                <a href="/{{$type}}/{{Auth::user()->id}}/ReceivedApplications"><span class="fa fa-files-o"></span> <span class="xn-text">Postulations reçues</span></a>
                    </li>


                    <li class="xn-openable {{ Request::is('*/posts') ? 'active' : '' }} ">
                                <a href=""><span class="fa fa-files-o"></span> <span class="xn-text">Sujets</span></a>
                                <ul>
                                    <li class="{{ Request::is('*/posts') ? 'active' : '' }}" >
                                        <a href="/{{$type}}/posts"><span class="fa fa-files-o"></span> <span class="xn-text">Mes sujets proposés</span></a>
                                    </li>  
                         
                                    <li >
                                                <a href="/{{$type}}/{{Auth::user()->id}}/MentoredPosts">
                                                <span class="fa fa-files-o"></span> <span class="xn-text">Mes Sujets encadrés</span></a>
                                    </li>
                                    @if($type == 'teacher')
                                    <li >
                                                <a href="/teacher/{{Auth::user()->id}}/PostsTovalidate">
                                                <span class="fa fa-files-o"></span> <span class="xn-text">Sujets à valider</span></a>
                                    </li>
                                    @endif

                                    
                                </ul>
                    </li>
                    
                    @endif
                            
                    <li>
                        
                        <a href="#"
                        class="mb-control" data-box="#mb-signout">
                        <span class="fa fa-power-off"></span> 
                        <span class="xn-text">Se déconnecter</span></a>

                        
                        
                    </li>  

                    <li><span class="xn-text"> </span></li>               
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->

            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="/User/#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                    <li class="xn-search">
                        <form role="form"  method="GET" action="/{{$type}}/home/search" >
                            <input type="text" name="keywords" placeholder="Rechercher..." autocomplete="off"
                            value="{{old('keywords')}}"  />
                            
                        </form>
                    </li>   
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a class="mb-control" data-box="#mb-signout"><span class="fa fa-power-off"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                    
                    <!-- Notifications -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" data-userid="{{Auth::user()->id}}" id="Notif"><span class="fa fa-globe"></span></a>
                        <div class="informer informer-danger">
                        @if($count>0){{  $count }}@endif
                        </div>
                        
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="color: black;"><span class="fa fa-globe"></span> Notifications </h3>                                
                                <div class="pull-right">
                                    <span class="label label-danger">{{  $count==0 ?'Aucune Nouvelle': $count.' Nouvelles'  }}</span>
                                </div>
                            </div>
                           

                            <div class="panel-body list-group scroll" style="height: 200px;">
                            @foreach($Notifications as $Notification)                       
                                <a  class="list-group-item" style="{{($Notification->is_New) ? 'background: rgba(255,0,0,0.1);' :'' }}" >

                                    <strong>{{$Notification->Titre}}</strong>
                                    <br>
                                    <p>{{$Notification->Content}}</p>
                                    <b><small class="text-muted">{{strftime('%A %d %B %Y à %H:%M' ,strtotime( $Notification->created_at)) }}</small></b>

                                </a>
                              @endforeach                             
                            </div>
                           
                               

                            

                        </div>                        
                    </li>


                    <!-- END TASKS -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                 <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/{{$type}}/home">Bienvenue</a></li>                    
                    @yield('path')
                </ul>
                <!-- END BREADCRUMB -->  
                                      
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    @yield('Content')
                </div>
                
                <!-- END PAGE CONTENT WRAPPER -->


            </div>            
            <!-- END PAGE CONTENT -->

        </div>
        <!-- END PAGE CONTAINER -->

     <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Se <strong>Déconnecter</strong> ?</div>
                    <div class="mb-content">
                        <p>Êtes-vous sûr de bien vouloir vous déconnecter?</p>                    
                        <p>
                        Appuyez sur Non si vous souhaitez continuer le travail. Appuyez sur Oui pour vous déconnecter.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="/{{$type}}/logout"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"
                                                  class="btn btn-success btn-lg">Oui</a>
                            <button class="btn btn-default btn-lg mb-control-close">Non</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- Logout Form -->
        <form id="logout-form" 
            action="/{{$type}}/logout"  method="POST"  style="display: none;">
                    {{ csrf_field() }}
        </form>
        <!--  END Logout Form -->


        <!-- START PRELOADS -->
        <audio id="audio-alert" src="/User/audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="/User/audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                  
        
    <!-- START SCRIPTS -->
        

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='/User/js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="/User/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="/User/js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        @yield('plugins scripts') 
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START  -->
        <script type="text/javascript" src="/User/js/settings.js"></script>     
        <script type="text/javascript" src="/User/js/plugins.js"></script>        
        <script type="text/javascript" src="/User/js/actions.js"></script>  

           
        <!-- END  -->


    <!-- END SCRIPTS -->         
    </body>
</html>