@extends('admin.layouts.AdminLayout')

@section('content')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Enseignants
      </h1>
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
  </section>
<br>
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Trier</h3>
            </div>
               <form action="{{ route('admin.trier.teachers')}}" method="post">
                                    {{ csrf_field() }}
            <div class="box-body">
                 <div class="col-xs-4">  
                  <select name="option" class="form-control">
                    <option value='nom'>Nom</option>
                    <option value='prenom'>Prénom</option>
                  </select>       
                </div>
                <div class="col-xs-4">  
                  <select name="type" class="form-control">
                    <option value="ASC">Ascendant</option>
                    <option value="DESC">Descendant</option>
                  </select>       
                </div>
             <div class="col-xs-4">  
               <button type="submit" class="btn btn-block btn-info btn-flat">Trier
                  </button>
              </div>
            </div>
             </form>
          </div>
 <div class="col-xs-12"> 
 <button type="button" class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#newTeacher">Ajouter un nouveau enseignant
                  </button>
                  <br>
                  </div>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
               <div class="col-xs-6">  
                  <select id="affiche" class="form-control">
                    <option>Tout</option>
                    <option>Approuvé</option>
                    <option>En attente</option>
                  </select>       
                </div>
                <div class="input-group col-xs-6">
                  <input type="text" id="SearchInput" onkeyup="SearchFunction()" name="table_search" class="form-control pull-right" placeholder="Entrer nom/prénom pour rechercher...">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
       
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="SearchIn" class="table table-hover">
                <tr>
                  <th>Nom d'utilisateur</th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>E-mail</th>
                  <th>Grade</th>
                  <th>Numéro de téléphone</th>
                  <th>Date de demande</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>

               @foreach($users as $user)
                <tr>
                  <td>{{ $user->username }}</td>
                  <td>{{ $user->Nom }}</td>
                  <td>{{ $user->Prenom }}</td>
                  <td>{{ $user->email }}</td>             
                  <td>{{ $user->Grade }}</td>
                  <td>{{ $user->Telephone }}</td>
                  <td>{{ $user->created_at }}</td>
                  <td>
                  @if($user->is_Approved == 1)
                    <span class="label label-success">Approuvé</span>
                  @else
                    <span class="label label-danger">En attente</span>
                  @endif
                  </td>
                  <td><div class="input-group-btn">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    <li>
                    @if($user->is_Approved == 1)
                        <form action="{{ route('admin.désapprove.user',['id' => $user->id,'user' => 'teachers'])}}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désaprouvé" type="submit">
                        </form>
                    @else
                        <form action="{{ route('admin.approve.user',['id' => $user->id,'user' => 'teachers']) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Approuver" type="submit">
                        </form>   
                    @endif
                    </li>
                    <li>
                        <form action="{{ route('admin.delete.user',['user' => 'teachers','id' => $user->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer" type="submit" onclick="return confirm('Êtes vous sur de vouloir supprimer cet enseignant ?');">
                        </form>                           
                    </li>
                    <li>
                    @if($user->commission_de_validation_id != null)
                        <form action="{{ route('admin.desafect.commit',['id' => $user->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Retirer de la comission de validations" type="submit">
                        </form>   
                    @else
                        <input data-toggle="modal" data-target="#affect_commit" class="btn btn-link" value="Ajouter a une comission de validation" type="submit" onclick="$('#id_user').prop('value', '{{ $user->id }}');">
                    @endif
                    </li>
                  </ul>
                </div></td> 
                </tr>
               @endforeach  
                       <div id="affect_commit" class="modal fade" role="dialog">
          <div class="modal-dialog">
             <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        
                                  <span aria-hidden="true">&times;</span></button>
                                 <h4 class="modal-title" id="myModalLabel">Choisisseez une commission</h4>
                      </div>
                            <div class="modal-body">
                        <form action="{{ route('admin.affect.commit') }}" method="post">
                        {{ csrf_field() }}
                                      <select name="comission_id" class="form-control">
                                 @foreach($comissions as $comission)                                    
                                       <option value="{{$comission->id}}">{{ $comission->Nom}} {{$comission->Domaine}}</option>                           
                                 @endforeach   
                                 </select> 
                              <input id="id_user" name="id_user" value="" type="hidden">
                              <br>
                          <button type="submit" class="btn btn-primary">Ajouter a la comission</button>
                          </form>           
                          </div>
                         </div>       
                      </div>
                      </div>              
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
 
          <!-- /.box -->
        </div>          
        </div>
      </div>
 <div class="modal fade" id="newTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

      <form method="POST" action="{{ route('admin.create.teacher') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ajouter un enseignant</h4>
              </div>

              <div class="modal-body">
                 <div class="form-group">
                  <label class="col-lg-3">Nom d'utilisateur</label>
                  <div class="col-lg-9">
                  <input name='username' type="text" class="form-control" placeholder="Entrer le nom d'utilisateur">
                  </div>
                </div>
           <br><br>
                <div class="form-group">
                  <label class="col-lg-3">Nom</label>
                  <div class="col-lg-9">
                  <input name='nom' type="text" class="form-control" placeholder="Entrer le nom">
                  </div>
                </div>
          <br><br>
              <div class="form-group">
                  <label class="col-lg-3">Prénom</label>
                  <div class="col-lg-9">
                  <input name='prenom' type="text" class="form-control" placeholder="Entrer le prénom">
                  </div>
              </div>
           <br><br>
               <div class="form-group">
                  <label class="col-lg-3" for="exampleInputEmail1">Email</label>
                  <div class="col-lg-9">
                  <input name='email' type="email" class="form-control" id="exampleInputEmail1" placeholder="Entrer l'email">
                  </div>
                </div>
                 <br><br>
                <div class="form-group">
                  <label class="col-lg-3" for="inputPassword3" class="control-label">Mot de passe</label>
                  <div class="col-lg-9">
                    <input name='password' type="password" class="form-control" id="inputPassword3" placeholder="Mot de passe">
                    </div>
                </div>
                 <br><br>
               <div class="form-group">
                  <label for="inputPassword3" class="col-lg-3 control-label">Confirmation mot de passe</label> 
                  <div class="col-lg-9">
                    <input name='password_confirmation' type="password" class="form-control" id="inputPassword3" placeholder="Mot de passe">
                    </div>
                </div>
                 <br><br>
              <div class="form-group">
                  <label class="col-lg-3">Numéro de téléphone</label>
                  <div class="col-lg-9">
                  <input name='tel' type="number" class="form-control" placeholder="Entrer le numéro de téléphone">
                  </div>
              </div>
              <br><br>
               <div class="form-group">
               <label class="col-lg-3">Grade</label>
                 <div class="col-lg-9">  
                  <select name='grade' class="form-control">
                    <option value='MAA'>MAA</option>
                    <option value='MAB'>MAB</option>
                    <option value='MCA'>MCA</option>
                    <option value='MCB'>MCB</option>
                    <option value='Professeur'>Professeur</option>
                    <option value='AT'>AT</option>
                  </select>       
                  </div>
                </div>
               <br><br>         
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
          </form>
        </div>
      </section> 
  </div>
@stop
@section('javascript')
<script>
function SearchFunction(){
  var input, filter, table, tr, td, i;
  input = document.getElementById("SearchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("SearchIn");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    td1 = tr[i].getElementsByTagName("td")[2];
    if (td){
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }

    if (td1){
      if (td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }  
  }
}
</script>
<script>
$(document).ready(function(){

$("#affiche").change(function(){

  var selected = $("#affiche").find(":selected").text();

  if(selected == 'Tout'){
  table = document.getElementById("SearchIn");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++){
     td = tr[i].getElementsByTagName("td")[1];
     if(td){
        tr[i].style.display = "";
     }
  }
  }

  if(selected == 'Approuvé'){
      table = document.getElementById("SearchIn");
      tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++){
     td = tr[i].getElementsByTagName("td")[7];

     if(td && td.getElementsByTagName("span")[0].innerHTML.indexOf('App') > -1){
        tr[i].style.display = "";
     }

     if(td && td.getElementsByTagName("span")[0].innerHTML.indexOf('En') > -1){
        tr[i].style.display = "none";
     }
  }
          
  }

 if(selected == 'En attente'){
      table = document.getElementById("SearchIn");
      tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++){
     td = tr[i].getElementsByTagName("td")[7];

     if(td && td.getElementsByTagName("span")[0].innerHTML.indexOf('App') > -1){
        tr[i].style.display = "none";
     }
     if(td && td.getElementsByTagName("span")[0].innerHTML.indexOf('En') > -1){
        tr[i].style.display = "";
     }
  }
          
  }

});
});
</script>
@stop