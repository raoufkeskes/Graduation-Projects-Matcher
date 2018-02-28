@extends('admin.layouts.AdminLayout')

@section('content')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Sujets
      </h1>
  </section>
<br>
      @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Opération réussite</h4>
                {{ Session::get('success') }}
      </div>
      @endif

      @if ($errors->any())
      <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-close"></i>Opération échoué</h4>
                @foreach($errors->all() as $error)
                <h4>{{ $error }}</h4>
                @endforeach
      </div>
      @endif

      @if(Session::has('error'))
      <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Opération échoué</h4>
                {{ Session::get('error') }}
      </div>
      @endif

      @if(Session::has('warning'))
      <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Opération non complète</h4>
                {{ Session::get('warning') }}
      </div>
      @endif
 <div class="col-xs-12"> 
 <a href="{{ route('admin.auto.affect') }}"><button type="button" class="btn btn-block btn-success btn-flat">Affectation automatique des commissions
                  </button></a>
                  <br>
                  </div>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header"> 
                <div class="input-group">
                  <input type="text" id="SearchInput" onkeyup="SearchFunction()" name="table_search" class="form-control pull-right" placeholder="Rechercher...">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>       
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="SearchIn" class="table table-hover">
                <tr>
                  <th>Titre</th>
                  <th>Domaine</th>
                  <th>Type sujet</th>
                  <th>Type proposeur</th>
                  <th>Proposeur</th>
                  <th>Commission de validation</th>
                  <th>Détails commission</th>
                  <th>Etat</th>
                  <th>Date proposition</th>
                  <th>Action</th>
                </tr>
           @foreach($subjects_students as $subject)
                <tr>
                  <td>{{ $subject->Titre }}</td>
                  <td>{{ $subject->Domaine }}</td>
                  <td>{{ $subject->Type }}</td>
                  <td>Etudiant</td>
                  <td>{{ $subject->Nom }} {{ $subject->Prenom }}</td>
                  <td><?php  $i = 0;  $bool = false;   
                       while($i < $posts->count() && !$bool){
                          if($posts[$i]->id == $subject->id){
                            if($posts[$i]->Validators()->count() > 0){
                              $bool = true;
                            echo $posts[$i]->Validators()->get()[0]->CommissionDeValidation()->get()[0]->Nom;
                              $commission_id = $posts[$i]->Validators()->get()[0]->CommissionDeValidation()->get()[0]->id;
                             }
                          }
                          $i++;
                       } ?>
                      <?php  if(!$bool){ ?>
              <input data-toggle="modal" data-target="#affect_commission" class="btn btn-link" value="Affecter une commission" type="submit" onclick="$('#id_post_commit').prop('value', '{{ $subject->id }}');
                     ">
                      <?php } 
                  ?></td>
                  <td><?php if(!$bool){ ?>Ce sujet n'as pas de commission de validation<?php }
                  else{ ?><a href="{{ route('admin.commit.details' , ['id' => $commission_id]) }}" >Details commission</a> <?php } ?></td>
                  <td>{{ $subject->Etat }}</td>
                  <td>{{ $subject->created_at }}</td>
                  <td>
                    <div class="input-group-btn">
                       <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                    <li>
                      <form action="{{ route('admin.delete.subject',['id'=> $subject->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer" type="submit" onclick="">
                      </form> 
                    </li>
                    <?php if($bool){ ?>
                    <li>
                     <form action="{{ route('admin.desafect.comission',['id'=> $subject->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désafecter commission" type="submit" onclick="">
                      </form> 
                    </li>
                    <?php } ?>
                         <li>
                   <input data-toggle="modal" data-target="#affect_teacher" class="btn btn-link" value="Affecter un encadreur" type="submit" onclick="$('#id_student').prop('value', '{{ $subject->student_id }}');
                     $('#id_post').prop('value', '{{ $subject->id }}');
                     $('#id_user').prop('value', '{{ $subject->user_id }}');">
                    </li>     
                  </div>
                  </td>
                </tr>
           @endforeach
         <div id="affect_teacher" class="modal fade" role="dialog">
          <div class="modal-dialog">
             <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                 <h4 class="modal-title" id="myModalLabel">Choisissez un enseignant</h4>
                               </div>
                            <div class="modal-body">
                              <form action="{{ route('admin.affect.teacher') }}" method="post">
                                  {{ csrf_field() }}
                                  <select name="teacher_id" class="form-control">
                                 @foreach($teachers as $teacher)                                    
                                       <option value="{{$teacher->id}}">{{ $teacher->Nom}} {{$teacher->Prenom}}</option>                           
                                 @endforeach   
                                 </select>    
                              <input id="id_student" name="id_student" value="" type="hidden">
                              <input id="id_post" name="id_post" value="" type="hidden">
                              <input id="id_user" name="id_user" value="" type="hidden">
                              <br>
                           <button type="submit" class="btn btn-primary">Affecter l'encadreur</button>
                         </form>                           
                     </div>
                </div>     
            </div>
          </div>
     

           @foreach($subjects_teachers as $subject)
                <tr>
                  <td>{{ $subject->Titre }}</td>
                  <td>{{ $subject->Domaine }}</td>
                  <td>{{ $subject->Type }}</td>
                  <td>Enseignat</td>
                  <td>{{ $subject->Nom }} {{ $subject->Prenom }}</td>
                  <td><?php  $i = 0;  $bool = false;   
                       while($i < $posts->count() && !$bool){
                          if($posts[$i]->id == $subject->id){
                            if($posts[$i]->Validators()->count() > 0){
                              $bool = true;
                            echo $posts[$i]->Validators()->get()[0]->CommissionDeValidation()->get()[0]->Nom;
                            $commission_id = $posts[$i]->Validators()->get()[0]->CommissionDeValidation()->get()[0]->id;
                            }
                          }
                          $i++;
                       } ?>
                      <?php  if(!$bool){ ?>
              <input data-toggle="modal" data-target="#affect_commission" class="btn btn-link" value="Affecter une comission" type="submit" onclick="$('#id_post_commit').prop('value', '{{ $subject->id }}');">
                      <?php } 
                  ?></td>
                  <td><?php if(!$bool){ ?>Ce sujet n'as pas de commission de validation<?php }
                  else{ ?><a href="{{ route('admin.commit.details' , ['id' => $commission_id]) }}" >Details commission</a> <?php } ?></td>
                  <td>{{ $subject->Etat }}</td>
                  <td>{{ $subject->created_at }}</td>
                  <td>
                    <div class="input-group-btn">
                       <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                    <li>
                   <input data-toggle="modal" data-target="#affect_student" class="btn btn-link" value="Affecter un étudiant" type="submit" onclick="$('#id_subject').prop('value', '{{ $subject->id }}');
                                                       $('#id_teacher').prop('value', '{{ $subject->teacher_id }}');">
                    </li>  
                    <li>
                      <form action="{{ route('admin.delete.subject',['id'=> $subject->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer sujet" type="submit" onclick="">
                      </form> 
                    </li> 
                    <?php if($bool){ ?>
                    <li>
                     <form action="{{ route('admin.desafect.comission',['id'=> $subject->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désafecter commission" type="submit" onclick="">
                      </form> 
                    </li>
                    <?php } ?>
                     </div>
                  </td>
                </tr>
           @endforeach
        <div id="affect_student" class="modal fade" role="dialog">
          <div class="modal-dialog">
             <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        
                                  <span aria-hidden="true">&times;</span></button>
                                 <h4 class="modal-title" id="myModalLabel">Entrer le matricule de l'étudiant</h4>
                               </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.affect.student.subject') }}" method="post">
                                  {{ csrf_field() }}
                              <input name="matricule" type="number" class="form-control">
                              <input id="id_subject" name="id_subject" value="" type="hidden">
                              <input id="id_teacher" name="id_teacher" value="" type="hidden">
                              <br>
                          <button type="submit" class="btn btn-primary">Affecter l'étudiant</button>
                          </form>                           
                           </div>
                         </div>
                        
                      </div>
                      </div>

           @foreach($subjects_companies as $subject)
                <tr>
                  <td>{{ $subject->Titre }}</td>
                  <td>{{ $subject->Domaine }}</td>
                  <td>{{ $subject->Type }}</td>
                  <td>Entreprise</td>
                  <td>{{ $subject->Raison_sociale }}</td>
<td><?php  $i = 0;  $bool = false;   
                       while($i < $posts->count() && !$bool){
                          if($posts[$i]->id == $subject->id){
                            if($posts[$i]->Validators()->count() > 0){
                              $bool = true;
                            echo $posts[$i]->Validators()->get()[0]->CommissionDeValidation()->get()[0]->Nom;
                            $commission_id = $posts[$i]->Validators()->get()[0]->CommissionDeValidation()->get()[0]->id;
                            }
                          }
                          $i++;
                       } ?>
                      <?php  if(!$bool){ ?>
              <input data-toggle="modal" data-target="#affect_commission" class="btn btn-link" value="Affecter une comission" type="submit" onclick="
                     $('#id_post_commit').prop('value', '{{ $subject->id }}');">
                      <?php } 
                  ?></td>
                  <td><?php if(!$bool){ ?>Ce sujet n'as pas de commission de validation<?php }
                  else{ ?><a href="{{ route('admin.commit.details' , ['id' => $commission_id]) }}" >Details commission</a> <?php } ?></td>
                  <td>{{ $subject->Etat }}</td>
                  <td>{{ $subject->created_at }}</td>
                  <td>
                    <div class="input-group-btn">
                       <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                    <li>
                      <form action="{{ route('admin.delete.subject',['id' => $subject->id])}}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer" type="submit" onclick="">
                      </form> 
                    </li>
                    <?php if($bool){ ?>
                    <li>
                     <form action="{{ route('admin.desafect.comission',['id'=> $subject->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désafecter commission" type="submit" onclick="">
                      </form> 
                    </li>
                    <?php } ?>  
                    </ul>  
                     </div>
                  </td>
                </tr>
           @endforeach
              <div id="affect_commission" class="modal fade" role="dialog">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                 <h4 class="modal-title" id="myModalLabel">Choisissez une commission</h4>
                               </div>
                            <div class="modal-body">
                              <form action="{{ route('admin.affect.comission') }}" method="post">
                                  {{ csrf_field() }}
                                  <select name="comission_id" class="form-control">
                                 @foreach($comissions as $comission)                                    
                                       <option value="{{$comission->id}}">{{ $comission->Nom}} {{$comission->Domaine}}</option>                           
                                 @endforeach   
                                 </select>    
                        
                              <input id="id_post_commit" name="id_post_commit" value="" type="hidden">
                              
                              <br>
                           <button type="submit" class="btn btn-primary">Affecter la comission</button>
                         </form>                           
                     </div>
                </div>     
            </div>
          </div>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>          
        </div>
      </div>
      </section>
@stop
@section('javascript')
<script>
function SearchFunction() {

  var input, filter, table, tr, td, i;
  input = document.getElementById("SearchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("SearchIn");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td){
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
@stop