@extends('admin.layouts.AdminLayout')

@section('css')
  <link rel="stylesheet" href="/admin_style/dashboard/css/blue.css">
  <link rel="stylesheet" href="/admin_style/dashboard/css/daterangepicker.css">
@stop

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Deadlines
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
      <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>Opération échoué</h4>
                {{ Session::get('error') }}
      </div>
      @endif
    </section>
    <section class="content">
    <div class="row">
      <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
            <form action="{{ route('admin.deadlines') }}" method="post">
            {{ csrf_field() }}
              <div class="form-group">
                <h4 class="col-lg-5">Phase Soumission :</h4>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="soumission" class="col-lg-7 form-control pull-right" id="soumission">
                </div>
              </div>
                 <br>
              <div class="form-group">
                <h4 class="col-lg-5">Phase validation :</h4>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="validation" class="col-lg-7 form-control pull-right" id="validation">
                </div>
              </div>
                 <br>
              <div class="form-group">
                <h4 class="col-lg-5">Phase candidature et affectation :</h4>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="candidature" class="col-lg-7 form-control pull-right" id="candidature">
                </div>
              </div>
                 <br>
                 <button class="btn btn-lg btn-primary pull-right" type="submit">Valider</button>
              </form>
                </div>
            </div>
          </div>
      </div>
    </div>
    </section>
 
  </div>
  @stop
@section('javascript')
<script src="/admin_style/dashboard/js/select2.full.min.js"></script>
<script src="/admin_style/dashboard/js/jquery.inputmask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="/admin_style/dashboard/js/daterangepicker.js"></script>
  <script>
  $(function () {
    $('#soumission').daterangepicker();
    $('#validation').daterangepicker();
    $('#candidature').daterangepicker();   
  });
</script>
@stop

