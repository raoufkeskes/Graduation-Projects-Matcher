@extends('user.Pages.UserProfile')


@php
                 $errorstab1  = old('username') || old('telephone') || old('raison_sociale') || old('matricule') || old('nom')  ||          old('prenom') || old('profession') ; 
@endphp
@section('DataName')
    @include('user.includes.nomprenomProfile' , ['errorstab1' => $errorstab1])

    										<div class="form-group">
                                            
                                                <label class="col-md-3 col-xs-12 control-label">Grade</label>
                                                <div class="col-md-6 col-xs-12">  
    												<select class="form-control select"  name="grade" >
                                                    <option {{$user->userable->Grade == 'AT' ? 'selected' : '' }}>AT</option>
                                                     <option {{$user->userable->Grade == 'MAB' ? 'selected' : '' }}>MAB</option>
                                                     <option {{$user->userable->Grade == 'MAA' ? 'selected' : '' }} >MAA</option>
								                    <option {{$user->userable->Grade == 'MCB' ? 'selected' : '' }}>MCB</option>
								                    <option {{$user->userable->Grade == 'MCA' ? 'selected' : '' }}>MCA</option>
								                    <option {{$user->userable->Grade == 'PROF' ? 'selected' : '' }}>PROF</option>   
                                                    </select> 
                                                </div>
                                            </div>

                                            <div class="form-group">
                                            
                                                <label class="col-md-3 col-xs-12 control-label">Profession</label>
                                                <div class="col-md-6 col-xs-12">                                                                                                                                                        
                                                    <input type="text" class="form-control" name="profession" 
                                                    value="{{ $errorstab1 ? old('profession') : $user->userable->Profession}}" autocomplete="off" />                                                    
                                                </div>
                                            </div>
@stop