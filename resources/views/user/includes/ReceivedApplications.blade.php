

@if(count($posts)==0)

  @include('errors.NoResults' , ['msg1' => 'Aucune Postulation ne vous été envoyée' , 'msg2' => 'Malheureusement ! En ce moment aucune postulation ne vous a été envoyé'] )
@else
<div class="row">
    <div class="col-md-12">
                <div class="panel panel-default">
            <div class="panel-body">
                <h3 class="push-down-0">Postulations reçues</h3>
            </div>
            <div class="panel-body faq">
                
                @foreach ($posts as $post)
                 <div id="{{$post->id}}" class="faq-item">
                    <div class="faq-title"><span class="fa fa-angle-down"></span>
                    {{$post->Titre}}</div>
                    @foreach ($post->StudentsRequesters as $student)
                    <div class="faq-text {{$student->user_id}}">
                        <div  class="StudentRow col-md-12">
                            <div class="col-md-9">
                            <img src="/{{$student->imagePath}}"
                                         class="pull-left" alt="No image"/>
                                        <span class="contacts-title">
                                         <a data-userid="{{$student->user_id}}"  data-toggle="modal"  data-target="#modal_basic" >{{$student->Nom}} {{$student->Prenom}}</a>
                                         
                                         </span>
                                        <p>Matricule : {{$student->Matricule}}</p>
                                        <p>Postulé le : {{$student->created}}</p>
                            </div>                                                                     
                            <div class="col-md-3">         
                                            <div class="btnBlock"  data-postid="{{$post->id}}" 
                                                data-userid="{{Auth::user()->id}}"
                                                data-studentid="{{$student->id}}"
                                                data-type="{{strtolower(Auth::user()->userable_type)}}" >
                                                
                                                <button  name="accept" 
                                                 class="{{(Auth::user()->userable_type == 'Teacher')
                                                 ?'AccepterPostulation':'AccepterPostulationCompany mb-control'}} btn btn-success"
                                                 data-box="#mb-Accept" >
                                                     Accepter
                                                </button>


                                                <button  name="refuse" class="refuserPostulation btn btn-danger">
                                                     Refuser
                                                </button>
                                            </div>
                            </div>
                        </div>

                                        
                            
                        
                    </div>
                    @endforeach
                </div>   
                @endforeach
                
                
                                
            </div>
        </div>
        
    </div>
</div>



     <div class="modal" id="modal_basic"  data-type="{{strtolower(Auth::user()->userable_type)}}"  tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
                        <h4 class="modal-title" id="defModalHead">Etudiant</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                          <div id="StudentData" class="hidden">
                            <div class="personalStudentData">
                              <label                 class="col-md-6 col-xs-6  text-right">Nom :</label>
                              <label id="nom"        class="col-md-6 col-xs-6  ">NOM</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Prénom :</label>
                              <label id="prenom"     class="col-md-6 col-xs-6  ">PRENOM</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Matricule :</label>
                              <label id="matricule"  class="col-md-6 col-xs-6  ">MATRICULE</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Specialité :</label>
                              <label id="specialite" class="col-md-6 col-xs-6  ">SPECIALITE</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Email :</label>
                              <label id="email"      class="col-md-6 col-xs-6  ">EMAIL</label>
                              <label                 class="col-md-6 col-xs-6  text-right">Etat :</label>
                              <label id="etat"      class="col-md-6 col-xs-6  ">monome</label>
                            </div>

                              <div class="col-md-12 col-xs-12">
                                      <fieldset class="moy">
                                          <legend>Cursus :</legend>
                                          <label         class="col-md-3 col-xs-6 text-right">1<sup>ère</sup> année:</label>
                                          <label id="L1" class="col-md-3 col-xs-6 "></label>
                                          <label         class="col-md-3 col-xs-6 text-right">2<sup>ème</sup> année:</label>
                                          <label id="L2" class="col-md-3 col-xs-6 "></label>
                                          <label         class="col-md-3 col-xs-6  text-right">3<sup>ème</sup> année:</label>
                                          <label id="L3" class="col-md-3 col-xs-6  "></label>
                                          <label         class="col-md-3 col-xs-6 text-right">Master 1:</label>
                                          <label id="M1" class="col-md-3 col-xs-6 "></label>
                                      </fieldset>
                              </div>
                              <div class="col-md-12 col-xs-12">
                                     <div class="gallery" id="links">
                                              
                                     </div> 
                              </div>
                          </div>

                          
                              <img  id="Loading" class="col-md-2 col-md-offset-5"  src="/img/ring.svg" alt="Loading ...">
                             
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
     </div>

         <!-- BLUEIMP GALLERY -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>      
        <!-- END BLUEIMP GALLERY -->
@endif
