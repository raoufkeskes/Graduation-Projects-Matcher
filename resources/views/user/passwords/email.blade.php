<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  
  <link rel="stylesheet" href="/ALL/css/normalize.min.css">
  <link rel="stylesheet" href="/Login_signup/css/Login_signupStyling.css">
</head>


<body class={{ $type }}>

  <div class="form">
      
      
      <div class="tab-content">

      <!-- Begin of Login -->

         <div>  
        
              <h1>Changement de mot de passe</h1>
              
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/'.$type.'/password/email') }}">
                {{ csrf_field() }} 

                <div class="field-wrap {{ ($errors->has('email') ) ? 'Error' :'NoError' }}">
                    <label  >
                      Email<span class="req">*</span>
                    </label>
                    <input type="text"  name ="email" value="{{ old('email') }}"required autocomplete />

                    <!-- LOADING -->
                    <div class ='hidden' id="loading">
                        <div class="load-5">
                            <div class="ring-2">
                                <div class="ball-holder">
                                    <div class="ball"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END LOADING -->

                    @if ($errors->has('email'))
                      <div class="error-msg">{{ $errors->first('email') }}</div>
                    @endif
                    @if (session('status'))
                        <div class="success-msg">Succès ! Vous venez de recevoir un email pour réinitialiser votre mot de passe</div>
                    @endif
                </div>

                <button id="loadingbutton" type="submit" class="button button-block"/>
                Envoyer</button>
              
              </form>

        </div>
      

       

      </div><!-- tab-content -->
      
</div> <!-- /form -->

  
    


    <script src='/ALL/js/jquery.min.js'></script>
    <script src="/Login_signup/js/Login_signup.js"></script>

</body>
</html>
