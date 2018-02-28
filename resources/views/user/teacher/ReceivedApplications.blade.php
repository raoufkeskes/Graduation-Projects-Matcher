@extends('user.layouts.MasterLayout')


@section('path')
   <li class="active">Postulations reçues</li>
@stop

@section('Content')
    @include('user.includes.ReceivedApplications')
@stop

@section('plugins scripts')
<!-- START THIS PAGE PLUGINS-->        
		 <script type='text/javascript' src='/User/js/plugins/noty/jquery.noty.js'></script>
         <script type='text/javascript' src='/User/js/plugins/noty/layouts/topCenter.js'></script>
         <script type='text/javascript' src='/User/js/plugins/noty/themes/default.js'></script>
    	 <script type="text/javascript" src="/User/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
    	<script type="text/javascript" src="/User/js/faq.js"></script>
        <script type="text/javascript" src="/User/js/raouf.js" ></script>
@stop 