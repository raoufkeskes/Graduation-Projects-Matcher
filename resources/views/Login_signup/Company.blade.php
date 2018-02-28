@extends('Login_signup.layouts.login_signup')



@section('form2')
<form action="/Company/register" method="post">
@stop


@section('registercontent')
<div class="field-wrap {{ $errors->has('raison_sociale') ? 'Error' :'NoError' }}">
              <label>
                Raison Sociale<span class="req">*</span>
              </label>
              <input type="text" name="raison_sociale" value ="{{old('raison_sociale')}}" required autocomplete="off" />
              @include('Login_signup.includes.errors' , ['data' => 'raison_sociale'])
</div>

<div class="field-wrap {{ $errors->has('raison_sociale') ? 'Error' :'NoError' }}">
              <label id="Justificatif">
                Justificatif<span class="req">*</span>
              </label>
              <input id="fileUploadBtn" type="file" name="justificatif"  required  accept="image/*"
              title="Exemple : Registre de Commerce scanné" />
              @include('Login_signup.includes.errors' , ['data' => 'justificatif'])
</div>

@stop
