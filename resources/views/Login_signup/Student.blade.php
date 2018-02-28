@extends('Login_signup.layouts.login_signup')



@section('nomprenom')
      @include('Login_signup.includes.nom_prenom')
@stop

@section('registercontent')
   <div class="field-wrap  {{ ($errors->has('matricule') ) ? 'Error' :'NoError' }}  ">
            <label>
              Matricule<span class="req">*</span>
            </label>
            <input type="text"  name ="matricule" pattern="[0-9]{12}" value ="{{old('matricule')}}"
             title="Exemple:201700001111" required autocomplete="off"/>
            @include('Login_signup.includes.errors' , ['data' => 'matricule'])
          </div>
          
          <!-- Selection du Niveau -->
          <div class="drop-menu {{ ($errors->has('Niveau') ) ? 'Error' :'NoError' }} ">
                    <div class="select">
                        <span id="Selectniveau" >Niveau</span>
                        <i class="fa fa-chevron-down" aria-hidden="true" ></i>
                    </div>
                          <input type="hidden" name="Niveau" value="" required >
                    <ul class="dropeddown">
                      <li >Licence</li>
                      <li >Master</li>
                    </ul>
          </div>
          @include('Login_signup.includes.errors' , ['data' => 'Niveau'])
          <!-- End Selection du niveau -->

          <!-- Specialités -->
                          <!--Licence -->
                          <div class="Licence" hidden >
                              <div class="container">

                                    <div class="radio-tile-group">
                                          @include('Login_signup.includes.specialites' , ['data' => 'Licence'])            
                                    </div>
                              </div>
                          </div>
                              <!--Licence END -->

                          <!--Master -->
                          <div class="Master" hidden >
                              <div class="container">

                                    <div class="radio-tile-group">
                                            @include('Login_signup.includes.specialites' , ['data' => 'Master'])  
                                    </div>
                              </div>
                          </div>
                              <!--Master END -->
          <!--End specialités -->
@stop