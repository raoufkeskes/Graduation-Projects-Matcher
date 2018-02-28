@extends('admin.layouts.AdminLayout')

@section('content')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Messages reçus
      </h1>
      <br>
      @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Opération réussite</h4>
                {{ Session::get('success') }}
      </div>
      @endif
  </section>

  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
       
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="SearchIn" class="table table-hover">
                <tr>
                  <th>Nom de l'expéditeur</th>
                  <th>Email de l'expéditeur</th>
                  <th>Sujet</th>
                  <th>Contenu</th>
                  <th>Supprimer</th>
                </tr>
              @foreach($messages  as $message)
                <tr>
                  <td>{{ $message->Nom }}</td>
                  <td>{{ $message->Email }}</td>
                  <td>{{ $message->Subject }}</td>
                  <td>{{ $message->Message }}</td>
                  <td><form action="{{ route('admin.delete.message',['id' => $message->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer ce message" type="submit" onclick="return confirm('Êtes vous sur de vouloir supprimer ce message ? ');">
                        </form></td>
             <!--     <td><div class="input-group-btn">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                    <span class="fa fa-caret-down"></span></button>
                  <ul class="dropdown-menu">
                    <li><form action="{{ route('admin.delete.commission',['id' => $message->id]) }}" method="post">
                        {{ csrf_field() }}
                        <input class="btn btn-link" value="Supprimer" type="submit" onclick="return confirm('Êtes vous sur de vouloir supprimer ce message ? ');">
                        </form></li>
                  </ul>
                </div></td> -->
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
      </section> 
  </div>
@stop
