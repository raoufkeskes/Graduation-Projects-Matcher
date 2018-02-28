<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
		<body>
    <div style="font-family: 'Helvetica Neue', Helvetica;    text-align: center;    padding: 5px; "> 
      <div style="width: 80%;      max-width: 800px;      font-weight: 300;      margin: 0 auto;      background-color: white;      border-radius: 15px;      padding: 15px;      padding-bottom: 15px">
        <h1 style="font-weight: 100">USTHB</h1>
        <p style="line-height: 1.5">
        Votre inscription a été établie avec succès veuillez la confirmer en cliquant sur ce lien .Cette confirmation
        vous sera utile pour protéger vos coordonnées .Si vous oubliez votre mot de passe vous pouvez le récuperer grâce a cette adresse e-mail.</p>
        <a href="{{url('/')}}/{{$person}}/register/confirmation/{{$token}}" 
        {{--url($type.'/password/reset', $this->token)--}}
        style="padding: 15px;        font-family: 'Helvetica Neue', Helvetica;        font-size: 18px;        color: white;        background-color: #2fc7ba;        border: 0;        border-radius: 5px;        margin: 10px;        display: block;        max-width: 200px;        margin: auto;        text-decoration: none">Confirmer mon  email</a>
    </div>
   </div>
    
  </body>
		
</body>
</html>