@extends('admin.layouts.AdminLayout')

@section('content')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Comissions de validation
      </h1>
      <br>
      @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Opération réussite</h4>
                {{ Session::get('success') }}
      </div>
      @endif

       @if(Session::has('error'))
      <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Opération réussite</h4>
                {{ Session::get('error') }}
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
 <div class="col-xs-12"> 
 <button type="button" class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#newValidationComit">Ajouter une nouvelle comission de validation
                  </button>
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
                  <th>Nom de la comission</th>
                  <th>Domaine</th>
                  <th>Enseignants</th>
                  <th>Action</th>
                </tr>
              @foreach($comissions as $comission)
                <tr>
                  <td>{{ $comission->Nom }}</td>
                  <td>{{ $comission->Domaine }}</td>
                  <td><a href="{{ route('admin.commit.details' , ['id' => $comission->id ]) }}">Voir liste enseignants</a></td>
                  <td><div class="input-group-btn">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    <li><form action="{{ route('admin.delete.commission',['id' => $comission->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer" type="submit" onclick="return confirm('Êtes vous sur de vouloir supprimer cette commission ? ');">
                        </form></li>
                  </ul>
                </div></td>
                </tr>
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
 <div class="modal fade" id="newValidationComit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" action="{{ route('admin.create.comission') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ajouter une nouvelle comission de validation</h4>
              </div>
              <div class="modal-body">
                 <div class="form-group">
                  <label class="col-lg-3">Nom de la comission</label>
                  <div class="col-lg-9">
                  <input name="name" type="text" class="form-control" placeholder="Entrer le nom de la comission">
                  </div>
                </div>
          <br><br>         
              <div class="form-group">
                  <label class="col-lg-3">Domaine</label>
              <div class="col-lg-9">
                  <select name="domaine" class="form-control">
                     
                                            <option>Génie Logiciel, Système d’Information et Base de Données</option>
                                            <option>Réseaux Sécurité, Réseaux Mobiles et Système d’Exploitation</option>
                                            <option>Intelligence Artificielle et Méta Heuristiques</option>
                                            <option>Développement Web et Mobile</option>
                                            <option>Architecture</option>
                                            <option>Vision et Imagerie</option>
                                            <option>Informatique Théorique</option>
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