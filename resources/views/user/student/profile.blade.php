@extends('user.Pages.UserProfile')

@php
    $errorstab3  = old('1ere_année') || old('2eme_année') ||old('3eme_année') || old('Master_1') ;
    $activaTab3  = $errorstab3 ||  session('status') == 'tab3' ;
    $errorstab1  = old('username') || old('telephone') || old('raison_sociale') || old('matricule') || old('nom')  ||          old('prenom') || old('profession') ;

@endphp



@section('DataName')
    @include('user.includes.nomprenomProfile'  , ['errorstab1' => $errorstab1]  )
                                            <div class="form-group">
                                            
                                                <label class="col-md-3 col-xs-12 control-label">Matricule</label>
                                                <div class="col-md-6 col-xs-12">                                                                                                                                                        
                                                    <input type="text" class="form-control" name ="matricule" 
                                                    pattern="[0-9]{12}" value ="{{ $errorstab1 ? old('matricule') : $user->userable->Matricule}}"
                                                    title="Exemple:201700001111" required autocomplete="off"/>                                                    
                                                </div>
                                            </div>



                                            <div class="form-group">
                                            
                                                <label class="col-md-3 col-xs-12 control-label">Specialité</label>
                                                <div class="col-md-6 col-xs-12">                                                                                                                                                        
                                                    <select class="form-control select"  name="specialite" >
                                                        <option  selected >Toutes les Specialités</option>
                                                        <optgroup label="Licence">
                                                        @foreach ($specialites['Licence'] as $specialite)
                                                            <option {{$user->userable->specialite == $specialite->spec ? 'selected' : '' }}  >
                                                            {{$specialite->spec}}</option>
                                                        @endforeach
                                                        </optgroup>

                                                        <optgroup label="Master">
                                                        @foreach ($specialites['Master'] as $specialite)
                                                            <option  {{$user->userable->specialite == $specialite->spec ? 'selected' : '' }} >{{$specialite->spec}}</option>
                                                        @endforeach
                                                        </optgroup>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                            
@stop


@section('CursusTab title')
                    <li  class="{{$activaTab3 ? 'active' : ''}}" ><a href="#tab-three"  role="tab" data-toggle="tab">Cursus</a></li>
@stop
@section('CursusTab')
             <div class="tab-pane {{$activaTab3 ? 'active' : ''}}" id="tab-three">

                                                @if($errorstab3)
                                                        <div class="alert alert-danger col-md-12 {{count($errors)==0 ? 'hidden' :''}}" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert">
                                                                <span aria-hidden="true">&times;</span>
                                                                <span class="sr-only">Close</span>
                                                        </button>
                                                        <h3 class="errors">Erreurs !</h3>
                                                        @foreach ($errors->all() as $error)
                                                            <strong> - {{$error}}</strong><br>
                                                        @endforeach
                                                         
                                                        </div>
                                                    @endif
                                                    @if (session('status')=='tab3' )
                                                    <div class="alert alert-success" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <strong>Vos moyennes ont été insérées avec Succès !</strong>
                                                    </div>
                                                    @endif 

                                                {!! Form::open(array('url'=>'/student/'.$user->id.'/Moyennes' , 'class'=>'form-horizontal','method'=>'POST')) !!}
                                                        
                                                     

                                                    <h3 class="text-center">Cursus Universitaire</h3>
                                                    <br>
                                                    <fieldset>
                                                    <legend>Moyennes générales</legend>
                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-2 col-xs-12 control-label">1
                                                        <sup>ere</sup> année :</label>
                                                        <div class="col-md-2 col-xs-12">                                                                              
                                                            <input  type="number" step="0.01" name="1ere_année" class="form-control" 
                                                            min="0" max="20" value="{{ isset($Cursus['L1']) ? $Cursus['L1'] : '' }}" 
                                                            required />
                                                                                                        
                                                        </div>

                                                        <label class="col-md-2 col-xs-12 control-label">2 
                                                        <sup>eme</sup> année :</label>
                                                        <div class="col-md-2 col-xs-12">                                                                              
                                                            <input  type="number" name="2eme_année" step="0.01" class="form-control"    value="{{isset($Cursus['L2']) ? $Cursus['L2'] : '' }}" 
                                                            min="0" max="20"
                                                            required />
                                                                                                        
                                                        </div>
                                                    </div>


                                                     @if($user->userable->specia->niveau == 'Master') 

                                                    <div class="form-group">
                                                        
                                                    

                                                       
                                                    
                                                    
                                                    
                                                        <label class="col-md-2 col-xs-12 control-label">3 
                                                        <sup>eme</sup> année :</label>
                                                        <div class="col-md-2 col-xs-12">                                                                              
                                                            <input  type="number" name="3eme_année" step="0.01" class="form-control"   value="{{isset($Cursus['L3']) ? $Cursus['L3'] : '' }}" 
                                                            min="0" max="20"
                                                            required />
                                                                                                        
                                                        </div>
                                                    

                                                    
                                                    
                                                        <label class="col-md-2 col-xs-12 control-label">Master 1:</label>
                                                        <div class="col-md-2 col-xs-12">                                                                              
                                                            <input  type="number" name="Master_1" step="0.01"  class="form-control"     value="{{isset($Cursus['M1']) ? $Cursus['M1'] : '' }}" 
                                                            min="0" max="20"
                                                            required />
                                                                                                        
                                                        </div>
                                                      
                                                    </div>

                                                    @endif 


                                                    


                                                
                                                    
                                                        
                                                    
                                                    
                                                <button type="submit" class="btn btn-primary pull-right">Envoyer<span class="fa fa-floppy-o fa-right"></span></button>
                                                 </fieldset>   
                                                </form>

                                                <fieldset>
                                                <Legend> <span class="fa fa-download"></span> Dropzone </Legend>
                                                    <div class="col-md-12">

                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                
                                                                <p>Ajouter vos relevés de notes sous format image pour avoir plus de chances d'être accepté rapidement!<br>
                                                                Note : Si vous avez uploadé votre cursus et vous voulez le modifier vous serrez sensé  réuploader toutes les images à nouveau</p>
                                                            
                                                                <form action="{{ url('/student/'.Auth::user()->id.'/CursusUpload')}}" class="dropzone text-center" id="my-awesome-dropzone">
                                                                     <div class="dz-message text-center"><span id="textDrag">Glissez vos fichiers  <br> ( ou cliquer ici ! ) </span></div>
                                                                     {{ csrf_field() }}
                                                                </form>
                                                            </div>
                                                        </div>                        

                                                    </div>
                                                </fieldset>

                                                                   

                                                </div>
             </div>
             <input id="user_id" type="hidden"  data-studentid="{{Auth::user()->id}}">

                                       
                                    
       <script type="text/javascript" src="/User/js/plugins/dropzone/dropzone.min.js"></script>
       <script type="text/javascript"  src="/User/js/dropezoneraouf.js" ></script>                
@stop