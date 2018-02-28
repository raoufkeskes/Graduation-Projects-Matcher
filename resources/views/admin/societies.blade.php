@extends('admin.layouts.AdminLayout')

@section('content')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Entreprises
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
            <form action="{{ route('admin.trier.companies')}}" method="post">
                                    {{ csrf_field() }}
            <div class="box-body">
                 <div class="col-xs-4">  
                  <select name='option' class="form-control">
                    <option value='Raison_sociale'>Raison social</option>
                    <option value='created_at'>Date demande</option>
                  </select>       
                </div>
                <div class="col-xs-4">  
                  <select name='type' class="form-control">
                    <option value='asc'>Ascendant</option>
                    <option value='desc'>Descendant</option>
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
 <button type="button" class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#newCompany">Ajouter une nouvelle entreprise
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
                    <option id="tout" value="tout">Tout</option>
                    <option id="approve" value="approve">Approuvé</option>
                    <option id="nonapprove" value="nonapprove">En attente</option>
                  </select>       
                </div>
            
              <div class="col-xs-6">  
                <div class="input-group">
                  <input type="text" id="SearchInput" onkeyup="SearchFunction()" name="table_search" class="form-control pull-right" placeholder="Entrer la raison social pour rechercher">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
              </div>
       
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="SearchIn" class="table table-hover" >
                <tr>
                  <th>Nom d'utilisateur</th>
                  <th>Raison social</th>
                  <th>Justificatif</th>
                  <th>E-mail</th>
                  <th>Numéro de téléphone</th>
                  <th>Date de demande</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>
             @foreach($users as $user)
               <tr>
                 <td>{{ $user->username }}</td>
                 <td>{{ $user->Raison_sociale }}</td>
                 <td><input data-toggle="modal" data-target="#registre" class="btn btn-link" value="voir justificatif" type="submit" onclick="$('#registre_image').prop('src', '/{{ $user->registre_image }}');"></td>
                 <td>{{ $user->email }}</td>
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
                        <form action="{{ route('admin.désapprove.user',['id' => $user->id,'user' => 'societies'])}}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désaprouvé" type="submit">
                        </form>
                    @else
                        <form action="{{ route('admin.approve.user',['id' => $user->id,'user' => 'societies']) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Approuvé" type="submit">
                        </form>   
                    @endif
                    </li>
                    <li>
                        <form action="{{ route('admin.delete.user',['user' => 'societies','id' => $user->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer" type="submit" onclick="return confirm('Êtes vous sur de vouloir supprimer cette entreprise ?');">
                        </form>                           
                    </li>
                    <li>
                    <form>
                       <a href="https://www.lespagesmaghreb.com/firms?commit=&search%5Bconditions%5D%5Bactive%5D=1&search%5Bconditions%5D%5Bcountry%5D=5&search%5Bkeywords%5D={{ $user->Raison_sociale }}" target="_blank"><input class="btn btn-link" value="Vérifier dans PagesMaghreb"></a>
                       </form>
  
                    </li>
                  </ul>
                </div></td> 
              </tr>
              <div id="registre" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                       <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                             <h4 class="modal-title" id="myModalLabel">Justificatif que c'est une entreprise</h4>
                           </div>
                        <div class="modal-body">
                          <img id="registre_image" width="100%">
                        </div>
                      </div>
                    </div>
                  </div>
             @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>          
        </div>
      </div>
      <div class="modal fade" id="newCompany" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
       <form method="POST" action="{{ route('admin.create.company') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ajouter une nouvelle entreprise</h4>
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
                  <label class="col-lg-3">Raison social</label>
                  <div class="col-lg-9">
                  <input name="rs" type="text" class="form-control" placeholder="Entrer le nom de l'entreprise">
                  </div>
                </div>
               <br><br>
                <div class="form-group">
                  <label class="col-lg-3">Numéro de téléphone</label>
                  <div class="col-lg-9">
                  <input name="tel" type="number" class="form-control" placeholder="Entrer le numéro de téléphone">
                  </div>
              </div>
              <br><br>
              <div class="form-group">
                  <label class="col-lg-3" for="register">Justificatif que c'est une entreprise</label>
                  <input name="registre" type="file" id="register" >
              </div> 
              </div>
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
function SearchFunction() {

  var input, filter, table, tr, td, i;
  input = document.getElementById("SearchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("SearchIn");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
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
     td = tr[i].getElementsByTagName("td")[6];

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
     td = tr[i].getElementsByTagName("td")[6];

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