<div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title-centered"><strong>Proposer un sujet</strong></h3>
                    
                </div>

               
                <div class="panel-body">                                                                        
                    
                    <div class="row">

                        
                           
                        
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
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong>Votre sujet a été créé avec Succès!</strong>
                        </div>

                        
                            
                       
                        @endif

                        
                                             
                            
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Titre</label>
                                <div class="col-md-9">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input required autocomplete="off" type="text" name="titre" class="form-control"
                                        value="{{old('titre')}}" />
                                    </div>                                            
                                    <span class="help-block">Ce champs est obligatoire</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Domaine</label>
                                <div class="col-md-9"  >                                                                                            
                                    <select class="form-control select"  name="domaine" id="selectdomaine" 
                                    title="Selectionner Un Domaine"  data-old="{{old('domaine')}}"  >
                                    		<option  data-hidden="true"></option>
                                        	<option >Génie Logiciel, Système d’Information et Base de Données</option>
                                            <option>Réseaux Sécurité, Réseaux Mobiles et Système d’Exploitation</option>
                                            <option>Intelligence Artificielle et Méta Heuristiques</option>
                                            <option>Développement Web et Mobile</option>
                                            <option>Architecture</option>
                                            <option>Vision et Imagerie</option>
                                            <option>Informatique Théorique</option>
                                    </select>
                                    <span class="help-block">Vous devez selectionner un domaine</span>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Orienté</label>
                                <div class="col-md-9">                                                                                            
                                    <select id="oriente" class="form-control select" name="oriente" 
                                     data-old="{{old('oriente')}}" >
                                            <option selected >Recherche & Pratique</option>
                                            <option  >Recherche</option>
                                            <option>Pratique</option>
                                    </select>
                                    <span class="help-block">Ce champs n'est pas obligatoire</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Résumé</label>
                                <div class="col-md-9 col-xs-12">                                            
                                    <textarea  name="resume" class="form-control" rows="10">{{old('resume')}}</textarea>
                                    <span class="help-block">le Contenu de votre projet et vos objectifs</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Plan de travail</label>
                                <div class="col-md-9 col-xs-12">                                            
                                    <textarea required name="workplan" class="form-control" rows="5"
                                    >{{old('workplan')}}</textarea>
                                    <span class="help-block">Ce champs est obligatoire</span>
                                </div>
                            </div>


                            
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Bibliographie</label>
                                <div class="col-md-9 col-xs-12">                                            
                                    <textarea class="form-control" rows="5" name="bibliographie"
                                    >{{old('bibliographie')}}</textarea>
                                    <span class="help-block">Ce champs n'est pas obligatoire</span>
                                </div>
                            </div>
                            
                            

                            @include('user.includes.destine_a_specialites')



                            <div class="form-group">
                                <label class="col-md-3 control-label">Mots-clés</label>
                                <div class="col-md-9">
                                    <input autocomplete="off" type="text" class="tagsinput"  name="tags" id="tags" 
                                    value="{{ old('tags') }}"/>
                                    <span class="help-block">Les mots-clés facilitent la recherche</span>
                                </div>
                            </div>

                           @yield('imgPart')
                        
                        </div>
                        
                    </div>

                </div>
                <div class="panel-footer">
                                                        
                    <button type="submit" class="btn btn-primary col-md-2 pull-right">Créer</button>
                    <button id="vider" type="reset" class="btn btn-info">Vider tout les champs</button>
                </div>

</div>

