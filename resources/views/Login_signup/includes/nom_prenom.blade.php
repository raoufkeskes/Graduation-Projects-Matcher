<div class="field-wrap  {{ ($errors->has('nom') ) ? 'Error' :'NoError' }} ">
      <label>
             Nom<span class="req">*</span>
      </label>
      <input class="nom" type="text" name="nom" value="{{ old('nom') }}" required  pattern="[À-ÿa-zA-Z\s]+"
      title="Le nom doit contenir que des lettres et des espaces " autocomplete="off" />
      @include('Login_signup.includes.errors' , ['data' => 'nom'])
</div>

<div class="field-wrap  {{ ($errors->has('prenom') ) ? 'Error' :'NoError' }} ">
      <label>
        Prénom<span class="req">*</span>
      </label>
      <input class="prenom" type="text" value="{{ old('prenom') }}" name="prenom"  pattern="[À-ÿa-zA-Z\s]+"
      title="Le prénom doit contenir que des lettres et des espaces " required autocomplete="off" />
      @include('Login_signup.includes.errors' , ['data' => 'prenom'])
</div>