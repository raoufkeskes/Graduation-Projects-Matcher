<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gestion pfe</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="/admin_style/dashboard/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admin_style/dashboard/css/all.css">
  <link rel="stylesheet" href="/admin_style/dashboard/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/admin_style/dashboard/css/_all-skins.min.css">
@yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="/admin" class="logo">
      <span class="logo-lg"><b>USTHB</b></span>
    </a>   
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">              
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/admin_style/dashboard/img/admin.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">

              <li>
                
                 
                                        <a href="{{ route('Adminlogout') }}"
                                           class="btn btn-default btn-flat"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Se déconnecter
                                        </a>
                                        <form id="logout-form" action="{{ route('Adminlogout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>             

              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/admin_style/dashboard/img/admin.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li class="header">Administrateur gestion PFE</li>
        <li class="{{ Request::is('admin') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Tableau de bord</span>
          </a>
        </li>
       <li class="{{ Request::is('*/societies') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.societies')}}">
            <i class="fa fa-industry"></i> <span>Entreprises</span>
          </a>
        </li>
       <li class="{{ Request::is('*/students') ? 'active' : '' }} treeview">
          <a href="#">
            <i class="fa fa-graduation-cap"></i> <span>Etudiants</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
            </span>
          <ul class="treeview-menu">
            <li class="{{ Request::is('*/monomes/students') ? 'active' : ''}}"><a href="{{ route('admin.monomes.students') }}"><i class="fa fa-graduation-cap"></i>Etudiants monomes</a></li>
            <li class="{{ Request::is('*/binomes/students') ? 'active' : ''}}"><a href="{{ route('admin.binomes.students') }}"><i class="fa fa-graduation-cap"></i>Etudiants binomes</a></li>
          </ul>
          </a>
        </li>
        <li class="{{ Request::is('*/teachers') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.teachers')}}">
            <i class="fa fa-pencil"></i><span>Enseignants</span>
          </a>
        </li>        
        <li class="{{ Request::is('*/subjects') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.subjects')}}">
            <i class="fa fa-file"></i><span>Sujets</span>
          </a>
        </li>
        <li class="{{ Request::is('*/projects') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.projects')}}">
            <i class="fa fa-file-text"></i><span>Projets affectés</span>
          </a>
        </li>
        <li class="{{ Request::is('*/validationcom') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.validation')}}">
            <i class="fa fa-check-circle"></i> <span>Comissions de validation</span>
          </a>
        </li>
        <li class="{{ Request::is('*/messages') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.messages')}}">
            <i class="fa fa-commenting"></i> <span>Messages</span>
          </a>
        </li>
        <li class="{{ Request::is('*/settings') ? 'active' : '' }} treeview">
          <a href="{{ route('admin.settings')}}">
            <i class="fa fa-history"></i> <span>Deadlines</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>
@yield('content')
<script src="/admin_style/dashboard/js/jquery-2.2.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="/admin_style/dashboard/js/bootstrap.min.js"></script>
<script src="/admin_style/dashboard/js/app.min.js"></script>
@yield('javascript')
</body>
</html>