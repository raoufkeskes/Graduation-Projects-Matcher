@extends('Login_signup.layouts.Success')

@section('content')
<div class="row">
				<div class="modalbox success col-sm-8 col-md-6 col-lg-5 center animate">
						<div class="icon">
								<span class="glyphicon glyphicon-ok"></span>
						</div>
						<!--/.icon-->
						<h1>Succès!</h1>
						<p>
						Vous venez de recevoir un e-mail de confirmation
						pour activer votre compte .
						Vous devez aussi patienter pendant que l'administration
						vérifie vos coordonnées et approuve votre compte
						</p>
						<a href="/"><button type="button" class="redo btn">Ok</button></a>
				</div>
				<!--/.success-->
		</div>

@stop