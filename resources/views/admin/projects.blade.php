@extends('admin.layouts.AdminLayout')

@section('content')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Projets affectés
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
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">             
                <div class="input-group col-xs-12">
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
                  <th>Etudiant</th>
                  <th>Promoteur interne</th>
                  <th>Promoteur externe</th>
                  <th>Action</th>
                </tr>

                @foreach($projects_internes as $project)
                <tr>
                  <td>{{ $project->Titre }}</td>
                  <td>{{ $project->Domaine }}</td>
                  <td>{{ $project->Nom_student }} {{ $project->Prenom_student }}</td>
                  <td>{{ $project->Nom_teacher }} {{ $project->Prenom_teacher }}</td>
                  <td>Sujet interne</td>
                  <td><div class="input-group-btn">
                       <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                    <li>
                      <form action="{{ route('admin.desafect.teacher',['id'=> $project->user_id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désafecter encadreur" type="submit" onclick="">
                      </form>           
                    </li>   
                     </div></td>
                </tr>
                @endforeach

                @foreach($projects_externes as $project)
                <tr>
                  <td>{{ $project->Titre }}</td>
                  <td>{{ $project->Domaine }}</td>
                  <td>{{ $project->Nom_student }} {{ $project->Prenom_student }}</td>
                  <td>{{ $project->Nom_teacher }} {{ $project->Prenom_teacher }}</td>
                  <td>{{ $project->Nom_representant }} {{$project->Prenom_representant }} | {{ $project->Raison_sociale }}</td>
                  <td><div class="input-group-btn">
                       <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                    <li>
                      <form action="{{ route('admin.desafect.subject_externe',['id'=> $project->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Désafecter sujet" type="submit" onclick="">
                      </form> 
                    </li>   
                     </div></td>
                </tr>
                @endforeach
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