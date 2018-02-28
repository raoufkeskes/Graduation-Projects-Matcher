@extends('user.Pages.UserProfile')


@php
	 $errorstab1  = old('username') || old('telephone') || old('raison_sociale') || old('matricule') || old('nom')  ||          old('prenom') || old('profession') ;
@endphp
@section('DataName')
											<div class="form-group">
                                            
                                                <label class="col-md-3 col-xs-12 control-label">Raison Sociale</label>
                                                <div class="col-md-6 col-xs-12">                                                                                                                                                        
                                                    <input type="text" class="form-control" name="raison_sociale" 
                                                    value ="{{ $errorstab1 ? old('raison_sociale') : $user->userable->Raison_sociale}}" required autocomplete="off"/>                                                    
                                                </div>
                                            </div>
@stop
