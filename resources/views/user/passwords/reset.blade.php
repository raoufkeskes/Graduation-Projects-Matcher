<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="/ALL/css/normalize.min.css">
  <link rel="stylesheet" href="/Login_signup/css/Login_signupStyling.css">
</head>

<body class={{ $type }} >

  <div class="form">
      
      
      <div class="tab-content">

      <!-- Begin of Login -->

         <div>  
        
              <h1>Changement de mot de passe</h1>
              
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/'.$type.'/password/reset') }}">
                {{ csrf_field() }} 
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="field-wrap {{ ($errors->has('email') ) ? 'Error' :'NoError' }}">
                    <label  >
                      Email<span class="req">*</span>
                    </label>
                    <input type="text"  name ="email" value="{{ old('email') }}"required autocomplete="off"/>
                    @include('Login_signup.includes.errors' , ['data' => 'email'])
                </div>


                <div class="field-wrap {{ $errors->has('password')  ? 'Error' :'NoError' }} ">
                  <label >
                    Mot de passe<span class="req">*</span>
                  </label>
                  <input type="password"   name="password" required autocomplete="off"/>
                  @include('Login_signup.includes.errors' , ['data' => 'password'])
                </div>


                <div class="field-wrap {{ $errors->has('password_confirmation')  ? 'Error' :'NoError' }} ">
                  <label >
                    Retaper votre mot de passe<span class="req">*</span>
                  </label>
                  <input type="password"   name="password_confirmation" required autocomplete="off"/>
                  @include('Login_signup.includes.errors' , ['data' => 'password_confirmation'])
                </div>

                @if (session('status'))
                        <div class="success-msg">Votre mot de passe a été réinitialisé avec succès !</div>
                @endif

                <button type="submit" class="button button-block"/>Réinitialiser</button>
              
              </form>

        </div>
      

       

      </div><!-- tab-content -->
      
</div> <!-- /form -->

  
    <script src='/ALL/js/jquery.min.js'></script>
    <script src="/Login_signup/js/Login_signup.js"></script>


</body>
</html>
