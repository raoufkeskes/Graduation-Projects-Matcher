<!DOCTYPE html>
<html>
<head>
<title>Create Admin</title>
<!-- For-Mobile-Apps -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Admin, Login, Design, Free templates, Responsive" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //For-Mobile-Apps -->
<!-- Style --> <link rel="stylesheet" href="{{ URL::asset('admin_style/login/css/style.css') }}" type="text/css" media="all" />
</head>
<body>
<div class="container">
<h1>Create Admin</h1>
	<div class="signin">
     	<form class="form-horizontal" role="form" method="POST" action="{{ route('admin.create') }}">
                        {{ csrf_field() }}

      @if ($errors->has('username'))
                          <label>{{ $errors->first('username') }}</label>
               @endif
	      	<input type="text" name="username" class="user" placeholder ="Nom d'utilisateur" />
 



   <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                            @if($errors->has('password'))
       
                                        <label>{{ $errors->first('password') }}</label>

                                @endif
                                    <input type="password" name="password" class="pass" 
                                    placeholder="Mot de passe"   />  
                            </div>
                        </div>	          	
          	<input type="submit" value="Create" />
	 
	     </form>

	</div>
</div>

</body>
</html>