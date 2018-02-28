@extends('user.layouts.MasterLayout')


@section('path')
   <li class="active">Postulations reçues</li>
@stop

@section('Content')
    @include('user.includes.ReceivedApplications')
	
<div class="message-box animated fadeIn" data-sound="alert" id="mb-Accept">
           
            <div id="companypromoteur" class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-user-circle"></span> <strong>Promoteur</strong> ?</div>
                    <div class="mb-content">
                        
                        

                           
                           
                           <form id="form1" class="form-horizontal">
                               
                               <br>
                                   <p class="text-center">Informations sur l'encadreur(Obligatoire)</p>

                                   
                                   <div class="form-group text-center">
                                            <label class="control-label">Employé Existant déjà ?</label>
                                            <div class="">
                                                <label class="switch switch-small">
                                                    <input id="checkbox1" name="EmployeExist" type="checkbox" value="0"/>
                                                    <span></span>
                                                </label>
                                            </div>
                                    </div>
                                   
                               <br>
                                                    
                                                    
                                                    <div id="newEmploye">
                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Nom :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="nom" class="form-control" 
                                                             />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Prénom :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="prenom" class="form-control"
                                                             
                                                            required />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Service :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="service" class="form-control" 
                                                              required />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Grade :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="grade" class="form-control" 
                                                            required    />
                                                                                                        
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    
                                                        <label class="col-md-3 col-xs-12 control-label">Profession :</label>
                                                        <div class="col-md-6 col-xs-12">                                                                              
                                                            <input type="text" name="profession" class="form-control" 
                                                            required   />
                                                                                                        
                                                        </div>
                                                    </div> 
                                                    </div>

                                                    <div id="oldEmploye" class="form-group hidden">
                                                            <label class="col-md-3 control-label">Vos encadreurs</label>
                                                            <div class="col-md-6">

                                                                        <select id="selectEmployee" class="form-control select required" data-live-search="true"
                                                                        name="selectEmployee">
                                                                            <option value="0">Aucun</option>
                                                                            
                                                                            @foreach ($employes as $employe)
                                                                                <option value="{{$employe->id}}">{{$employe->Nom.' '.$employe->Prenom}}</option>
                                                                            @endforeach
                                                                            
                                                                        </select>
                                                            </div>
                                                    </div>
                                
                                                       


                           </form>
                        

                            <div class="mb-footer">

                                                            <div class="pull-right">
                                                                <button id="AcceptCompany" 
                                                                
                                                                class="btn btn-success btn-lg"
                                                                >Oui</button>
                                                                <button class="btn btn-default btn-lg mb-control-close">Non</button>
                                                            </div>
                                                            
                                                            
                                                            
                            </div>

                            
                            
                       
                    </div>
                    
                </div>
            </div>
 </div>
@stop

@section('plugins scripts')
<!-- START THIS PAGE PLUGINS-->     

		<script type='text/javascript' src='/User/js/plugins/noty/jquery.noty.js'></script>
		<script type="text/javascript" src="/User/js/plugins/bootstrap/bootstrap-select.js"></script>  
	     <script type='text/javascript' src='/User/js/plugins/noty/layouts/topCenter.js'></script>
	     <script type='text/javascript' src='/User/js/plugins/noty/themes/default.js'></script>
    	<script type="text/javascript" src="/User/js/faq.js"></script>
		 <script type='text/javascript' src="/User/js/plugins/jquery-validation/jquery.validate.js"></script>
         <script type="text/javascript" src="/User/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
          <script type="text/javascript" src="/User/js/raouf.js" ></script>
         <script type="text/javascript" src="/User/js/FormValidationraouf.js"></script>
        
         

@stop