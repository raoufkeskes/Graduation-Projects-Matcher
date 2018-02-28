@extends('Login_signup.layouts.Success')


@section('content')
<div class="row">
				<div class="modalbox error col-sm-8 col-md-6 col-lg-5 center animate">
						<div class="icon">
								<span class="glyphicon glyphicon-thumbs-down"></span>
						</div>
						<!--/.icon-->
						<h1>Erreur!</h1>
						<p>Oops! Une erreur est survenue</p>
						<a href="/"><button type="button" class="redo btn">Page d'acceuil</button></a>
				</div>
				<!--/.success-->
</div>
<!--/.row-->

@stop
