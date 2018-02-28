@extends('user.layouts.MasterLayout')


@section('path')
   <li class="active">Mes Sujets encadrés</li>
@stop

@section('Content')
    @include('user.includes.MentoredPosts', ['posts' => $posts ])
@stop

@section('plugins scripts')
<!-- START THIS PAGE PLUGINS-->        
    	<script type="text/javascript" src="/User/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
        <script type="text/javascript" src="/User/js/raouf.js" ></script>
@stop 