@extends('admin.layouts.AdminLayout')

@section('content')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Etudiants {{ Request::is('*/monomes/students') ? $type='monomes' : $type='binomes' }}
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
  
            <form action="{{ route('admin.trier.'.$type.'.students')}}" method="post">
                                    {{ csrf_field() }}
            <div class="box-body">
                 <div class="col-xs-4">  
                  <select name='option' class="form-control">
                    <option value='Matricule'>Matricule</option>
                    <option value='Nom'>Nom</option>
                    <option value='Prenom'>Prénom</option>
                  </select>       
                </div>
                <div class="col-xs-4">  
                  <select name='type' class="form-control">
                    <option value='ASC'>Ascendant</option>
                    <option value='DESC'>Descendant</option>
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
 <button type="button" class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#newStudent">Ajouter un nouveau étudiant
                  </button>
                  <br>
                  </div>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
               <div class="col-xs-2">  
                  <select id="affiche" class="form-control">
                    <option>Tout</option>
                    <option>Approuvé</option>
                    <option>En attente</option>
                  </select>       
                </div>   
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
                  <th>Nom d'utilisateur</th>
                  <th>Matricule</th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Niveau</th>
                  <th>Spécialité</th>
              @if(Request::is('*/binomes*'))
                  <th>Binome de</th>
              @endif
                  <th>Date de demande</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>
                @foreach($users as $user)
                <tr>
                 <td>{{ $user->username }}</td>
                 <td>{{ $user->Matricule }}</td>
                 <td>{{ $user->Nom }}</td>
                 <td>{{ $user->Prenom }}</td>
                 <td>{{ $user->niveau }}</td>
                 <td>{{ $user->specialite }}</td>
                @if(Request::is('*/binomes*'))
                 <td><a href="#">{{ $user->nom_binome }} {{ $user->prenom_binome }}</a></td>
                @endif
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
                        <form action="{{ route('admin.désapprove.user',['id' => $user->id,'user' => Request::is('*/monomes/students') ? 'monomes' : 'binomes'])}}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désaprouvé" type="submit">
                        </form>
                    @else
                        <form action="{{ route('admin.approve.user',['id' => $user->id,Request::is('*/monomes/students') ? 'monomes' : 'binomes']) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Approuvé" type="submit">
                        </form>   
                    @endif
                    </li>
                    <li>
                        <form action="{{ route('admin.delete.user',['user' => Request::is('*/monomes/students') ? 'monomes' : 'binomes','id' => $user->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer" type="submit" onclick="return confirm('Êtes vous sur de vouloir supprimer cette entreprise ?');">
                        </form>                           
                    </li>
                   @if(Request::is('*/binomes*'))
                    <li>
                        <form action="{{ route('admin.desafect.binome',['user'=> 'binomes','id' => $user->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désafecter binome" type="submit" onclick="">
                        </form>                           
                    </li>
                   @else
                    <li>
                   <input data-toggle="modal" data-target="#affect_binome" class="btn btn-link" value="Affecter un binome" type="submit" onclick="$('#id_user').prop('value', '{{ $user->id }}');">
                    </li>
                   @endif
                </ul>
                </div></td>
                </tr>
                @endforeach
        <div id="affect_binome" class="modal fade" role="dialog">
          <div class="modal-dialog">
             <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        
                                  <span aria-hidden="true">&times;</span></button>
                                 <h4 class="modal-title" id="myModalLabel">Entrer le matricule du binome</h4>
                               </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.affect.binome',['user'=> 'binomes']) }}" method="post">
                        {{ csrf_field() }}
                              <input name="matricule" type="number" class="form-control">
                              <input id="id_user" name="id_user" value="" type="hidden">
                              <br>
                          <button type="submit" class="btn btn-primary">Affecter le binome</button>
                          </form>                            </div>

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
    <div class="modal fade" id="newStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
       <form method="POST" action="{{ route('admin.create.student') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ajouter un étudiant</h4>
              </div>

              <div class="modal-body">
                 <div class="form-group">
                  <label class="col-lg-3">Nom d'utilisateur</label>
                  <div class="col-lg-9">
                  <input name="username" type="text" class="form-control" placeholder="Entrer le nom d'utilisateur">
                  </div>
                </div>
           <br><br>
                <div class="form-group">
                  <label class="col-lg-3">Nom</label>
                  <div class="col-lg-9">
                  <input name="nom" type="text" class="form-control" placeholder="Entrer le nom">
                  </div>
                </div>
          <br><br>
              <div class="form-group">
                  <label class="col-lg-3">Prénom</label>
                  <div class="col-lg-9">
                  <input name="prenom" type="text" class="form-control" placeholder="Entrer le prénom">
                  </div>
              </div>
           <br><br>
                <div class="form-group">
                  <label class="col-lg-3">Matricule</label>
                  <div class="col-lg-9">
                  <input name="matricule" type="number" class="form-control" placeholder="Entrer le matricule">
                  </div>
                </div>
       
           <br><br>
               <div class="form-group">
                  <label class="col-lg-3" for="exampleInputEmail1">Email</label>
                  <div class="col-lg-9">
                  <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Entrer l'email">
                  </div>
                </div>
                 <br><br>
                <div class="form-group">
                  <label class="col-lg-3" for="inputPassword3" class="control-label">Mot de passe</label>
                  <div class="col-lg-9">
                    <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Mot de passe">
                    </div>
                </div>
                 <br><br>
               <div class="form-group">
                  <label for="inputPassword3" class="col-lg-3 control-label">Confirmation mot de passe</label> 
                  <div class="col-lg-9">
                    <input name="password_confirmation" type="password" class="form-control" id="inputPassword3" placeholder="Mot de passe">
                    </div>
                </div>
                 <br><br>
              <div class="form-group">
                  <label class="col-lg-3">Numéro de téléphone</label>
                  <div class="col-lg-9">
                  <input name="telephone" type="number" class="form-control" placeholder="Entrer le numéro de téléphone">
                  </div>
              </div>
               <br><br>        
              <div class="form-group">
                  <label class="col-lg-4">Niveau - Spécialité</label>
              <div class="col-lg-4">
                  <select id="filiere" name="niveau" class="form-control">
                    <option id="licence" value="LICENCE">LICENCE</option>
                    <option id="master" value="MASTER">MASTER</option>
                  </select>
             </div>
              <div class="col-lg-4">
                  <select id='spec' name="specialite" class="form-control">
                    <option value="ISIL">ISIL</option>
                    <option value="ACAD">ACAD</option>
                    <option value="GTR">GTR</option>
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
        </div>
        </form>
      </section> 
  </div>
@stop
@section('javascript')
<script>
$(document).ready(function(){

$("#filiere").change(function(){

  var select = $("#spec");
  var selected = $("#filiere").find(":selected").text();

  if(selected == 'MASTER'){
    select.empty().append('<option value="SII">SII</option><option value="RSD">RSD</option><option value="IL">IL</option><option value="SSI">SSI</option><option value="APCI">APCI</option><option value="MIND">MIND</option><option value="INFVIS">INFVIS</option>');
  }
  else{
  select.empty().append('<option value="ISIL">ISIL</option><option value="ACAD">ACAD</option><option value="GTR">GTR</option>');
  }
});

});
</script>
<script>
function SearchFunction(){
  var input, filter, table, tr, td, i;
  input = document.getElementById("SearchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("SearchIn");
  tr = table.getElementsByTagName("tr");
  for(i = 0; i < tr.length; i++){
    td = tr[i].getElementsByTagName("td")[0];
    if(td){
      if(td.innerHTML.toUpperCase().indexOf(filter) > -1){
        tr[i].style.display = "";
      }else{
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
     td1 = tr[i].getElementsByTagName("td")[8]; 

     if((td && td.getElementsByTagName("span")[0] != null && td.getElementsByTagName("span")[0].innerHTML.indexOf('App') > -1) || (td1 && td1.getElementsByTagName("span")[0] != null && td1.getElementsByTagName("span")[0].innerHTML.indexOf('App') > -1)){
        tr[i].style.display = "";
     }

     if((td && td.getElementsByTagName("span")[0] != null && td.getElementsByTagName("span")[0].innerHTML.indexOf('En') > -1) || (td1 && td1.getElementsByTagName("span") != null && td1.getElementsByTagName("span")[0].innerHTML.indexOf('En') > -1)){
        tr[i].style.display = "none";
     }
  }
          
  }

 if(selected == 'En attente'){
      table = document.getElementById("SearchIn");
      tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++){
     td = tr[i].getElementsByTagName("td")[7];
     td1 = tr[i].getElementsByTagName("td")[8];

     if((td && td.getElementsByTagName("span")[0] != null && td.getElementsByTagName("span")[0].innerHTML.indexOf('App') > -1) || (td1 && td1.getElementsByTagName("span")[0] != null && td1.getElementsByTagName("span")[0].innerHTML.indexOf('App') > -1)){
        tr[i].style.display = "none";
     }
     if((td && td.getElementsByTagName("span")[0] != null && td.getElementsByTagName("span")[0].innerHTML.indexOf('En') > -1) || (td1 && td1.getElementsByTagName("span") != null && td1.getElementsByTagName("span")[0].innerHTML.indexOf('En') > -1)){
        tr[i].style.display = "";
     }
  }
          
  }

});

});


</script>
@stop