@extends('Login_signup.layouts.login_signup')




@section('nomprenom')
      @include('Login_signup.includes.nom_prenom')
@stop

@section('registercontent')
<!-- Selection du Grade -->
          <div class="drop-menu {{ ($errors->has('grade') ) ? 'Error' :'NoError' }}">
                    <div class="select">
                      <span id="Selectniveau" >Grade</span>
                      <i class="fa fa-chevron-down" aria-hidden="true" ></i>
                    </div>
                    <input type="hidden"  value="" name="grade">
                    <ul class="dropeddown">
                        <li>AT</li>
                        <li>MAB</li>
                        <li>MAA</li>
                        <li>MCB</li>
                        <li>MCA</li>
                        <li>PROF</li>           
                    </ul>
          </div>
          @include('Login_signup.includes.errors' , ['data' => 'grade'])
<!-- End Selection du Grade -->

<div class="field-wrap  {{ ($errors->has('profession') ) ? 'Error' :'NoError' }} ">
      <label>
        Profession
      </label>
      <input class="profession" type="text" value="{{ old('profession') }}" name="profession"  pattern="[a-zA-Z\s]+"
      title="Le champs  'profession'  doit contenir que des letteres et des espaces " required autocomplete="off" />
      @include('Login_signup.includes.errors' , ['data' => 'profession'])
</div>

@stop

      
          

