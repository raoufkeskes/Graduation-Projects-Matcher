
<?php
$specialites = App\Specialite::select('spec')->where('niveau',$data)->get();
?>
@foreach ($specialites as $specialite)
<div class="input-container">
     <input  class="radio-button" type="radio" value="{{$specialite->spec}}" name="Specialité" />
        <div class="radio-tile">
             <label for="{{$specialite->spec}}" class="radio-tile-label">{{$specialite->spec}}</label>
        </div>
</div>	
@endforeach

@include('Login_signup.includes.errors' , ['data' => 'Specialité'])