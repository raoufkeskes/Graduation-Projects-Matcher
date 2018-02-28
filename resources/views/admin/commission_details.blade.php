@extends('admin.layouts.AdminLayout')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Nom de la commission : {{ $commission->Nom }}
        <br><br>
        Domaine de la commission : {{ $commission->Domaine }}
      </h1> 
    </section>
    <section class="content">
    <div class="row">
      <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
            <form>
            <?php  $i = 1; ?>
            @foreach($teachers as $teacher)
              <div class="form-group">
                <h4 class="col-lg-5">Enseignant <?php echo $i; ?>  :  {{ $teacher->Nom }} {{ $teacher->Prenom }}</h4>
              </div>
            @endforeach    
              </form>
                </div>
            </div>
          </div>
      </div>
    </div>
    </section>
  </div>
@stop


