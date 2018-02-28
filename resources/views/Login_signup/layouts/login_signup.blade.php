<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/fonts/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="/ALL/css/normalize.min.css"> 
  <link rel="stylesheet" href="/Login_signup/css/Login_signupStyling.css">
</head>

@php
  /*this variable is to decide which tab(Login / Register)will be activated and which content 
  (Login content / Register content  ) will be displayed */
  $ReloadLogin = (( $errors->has('email') )   OR  ( $errors->has('password') )  OR  (count($errors)==0 ) ) ;
  
  //to define user type 
  $type = (pathinfo(Request::path() , 1 ) );
  
@endphp

<body class={{$type}}>




  <div class="form">
      
      <ul class="tab-group">
        <li id="tab1" class="tab {{ $ReloadLogin  ? 'active': ''}} "><a  href="#login">Connexion</a></li>
        <li id="tab2" class="tab {{!$ReloadLogin  ? 'active': ''}} "><a href="#signup">Inscription</a></li>
      </ul>
      
      <div class="tab-content">

      <!-- Begin of Login -->

        <div id="login" class="{{$ReloadLogin  ? '': 'hidden' }}" >  
        
              <h1>Bienvenue</h1>
              
              <form method="POST" action="{{ url('/'.$type.'/login') }}" >
                {{ csrf_field() }} 

                <div class="field-wrap {{ ($errors->has('email') ) ? 'Error' :'NoError' }}">
                    <label  >
                      Email ou Nom d'Utilisateur<span class="req">*</span>
                    </label>
                    <input type="text" id="userlogin" name ="email" value="{{ old('email') }}"required autocomplete/>
                    @include('Login_signup.includes.errors' , ['data' => 'email'])
                </div>
             
              
                <div class="field-wrap {{ $errors->has('password')  ? 'Error' :'NoError' }} ">
                  <label >
                    Mot de passe<span class="req">*</span>
                  </label>
                  <input type="password" id="passlogin"   name="password" required autocomplete="off"/>
                  @include('Login_signup.includes.errors' , ['data' => 'password'])
                </div>
                
                <div class="forgotRememberMe">
                      <input id="checkbox1" type="checkbox"  name="remember" {{ old('remember') ? 'checked' : '' }}>
                       <label for="checkbox1">Se souvenir de moi</label>

                      <div class="forgot"><a href="{{ url('/'.$type.'/password/reset') }}">Mot de passe oublié?</a></div>
                </div>
                

                <button type="submit" class="button button-block"/>Se Connecter</button>
              
              </form>

        </div>
      

        <!-- End of Login -->

        <!-- Sign up -->

        <div id="signup" class="{{$ReloadLogin  ? 'hidden': '' }}"  >

                <h1>Créer votre compte</h1>
                
                
                {!! Form::open(array('url'=>'/'.$type.'/register' ,'method'=>'POST', 'files'=>true)) !!}
                
                {{ csrf_field() }}
                
                @yield('nomprenom')  <!-- For teacher & Student --> 
                <div class="field-wrap {{ $errors->has('user') ? 'Error' :'NoError' }} ">
                    <label >
                      Nom d'utilisateur<span class="req">*</span>
                    </label>
                    <input type="text"   name="user" value="{{ old('user') }}" required 
                    pattern="[a-zA-Z0-9-_]+{4,30}" title="Le Nom d'utilisateur doit contenir que des chiffres , des letteres et des tirets et il doit contenir au minimum 4 caractères"  autocomplete="off" />
                 @include('Login_signup.includes.errors' , ['data' => 'user'])    
                </div>
                
               <div class="field-wrap {{ $errors->has('e-mail') ? 'Error' :'NoError' }} ">
                    <label>
                      E-mail<span class="req">*</span>
                    </label>
                    <input type="email" name="e-mail"  pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                      title="Exemple: exemple@exemple.com" value="{{ old('e-mail') }}" required autocomplete="off"/>
                      @include('Login_signup.includes.errors' , ['data' => 'e-mail'])
                </div>

                <div class="field-wrap {{ $errors->has('pass') ? 'Error' :'NoError' }}">
                    <label>
                      Mot de passe<span class="req">*</span>
                    </label>
                    <input type="password" name ="pass" pattern=".{8,}" 
                     title="Le mot de passe doit contenir au minimum 8 caractères"   required autocomplete="off"/>
                      @include('Login_signup.includes.errors' , ['data' => 'pass'])
                </div>

                <div class="field-wrap {{ $errors->has('password_confirm') ? 'Error' :'NoError' }} ">
                    <label>
                      Retaper votre mot de passe<span class="req">*</span>
                    </label>
                    <input type="password" name="password_confirm"   required autocomplete="off"/>
                     @include('Login_signup.includes.errors' , ['data' => 'password_confirm'])
                </div>

                <div class="field-wrap {{ $errors->has('telephone') ? 'Error' :'NoError' }}">
                    <label>
                      Téléphone<span class="req">*</span>
                    </label>
                    <input type="text"  name ="telephone"  pattern="0\d{8,9}" 
                    title="Exemple : 0555001122 / 021001122" value="{{ old('telephone') }}" autocomplete="off"/>
                    @include('Login_signup.includes.errors' , ['data' => 'telephone'])
                </div>

               @yield('registercontent')

               

                <button type="submit" class="button button-block"/>S'inscrire</button>

                </form>
           

        </div>
        <!--End of Sign up -->

      </div><!-- tab-content -->
      
</div> <!-- /form -->

  
    


    <script src='/ALL/js/jquery.min.js'></script>
    <script src="/Login_signup/js/Login_signup.js"></script>

</body>
</html>
