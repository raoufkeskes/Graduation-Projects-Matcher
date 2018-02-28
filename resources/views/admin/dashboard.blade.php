@extends('admin.layouts.AdminLayout')

@section('content') 
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tableau de bord
      </h1>
  </section>
<br>

    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">     
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $entreprises_inscrites }}</h3>
              <p>Entreprises inscrites</p>
            </div>
            <div class="icon">
              <i class="fa fa-industry"></i>
            </div>
            <a href="{{ route('admin.societies') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">     
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $entreprises_non_approuve }}({{$pourcentage_entreprises}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Entreprises non approuvé</p>
            </div>
            <div class="icon">
              <i class="fa fa-industry"></i>
            </div>
            <a href="{{ route('admin.societies') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">     
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$etudiants_inscrits}}</h3>
              <p>Etudiants inscrits</p>
            </div>
            <div class="icon">
              <i class="fa fa-graduation-cap"></i>
            </div>
            <a href="{{ route('admin.monomes.students') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">     
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$etudiants_non_approuve}}({{$pourcentage_etudiants}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Etudiants non approuvé</p>
            </div>
            <div class="icon">
              <i class="fa fa-graduation-cap"></i>
            </div>
            <a href="{{ route('admin.monomes.students') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         
        <div class="col-lg-3 col-xs-6">     
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$enseignants_inscrits}}</h3>
              <p>Enseignants inscrits</p>
            </div>
            <div class="icon">
              <i class="fa fa-pencil"></i>
            </div>
            <a href="{{ route('admin.teachers') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> 
         
        <div class="col-lg-3 col-xs-6">     
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$enseignants_non_approuve}}({{$pourcentage_enseignants}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Enseignants non approuvé</p>
            </div>
            <div class="icon">
              <i class="fa fa-pencil"></i>
            </div>
            <a href="{{ route('admin.teachers') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6"> 
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$sujets_valide}}({{$pourcentage_sujets_valide}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Sujets validés</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="{{ route('admin.subjects') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$sujets_non_valide}}({{$pourcentage_sujets_non_valide}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Sujets non validé</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="{{ route('admin.subjects') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6"> 
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$etudiants_qui_ont_sujet}}({{$pourcentage_etudiants_avec_sujet}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Etudiants qui ont un sujet</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="{{ route('admin.subjects') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
          </div>
         <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$etudiants_sans_sujet}}({{$pourcentage_etudiants_sans_sujet}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Etudiants sans sujets</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="{{ route('admin.subjects') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


      <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-gray">
            <div class="inner">
              <h3>{{$sujets_sans_comi_validation}}({{$pourcentage_sujet_sans_comission}}<sup style="font-size: 20px">%</sup>)</h3>
              <p>Sujets sans comission de validation</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-circle"></i>
            </div>
            <a href="{{ route('admin.subjects') }}" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>
    </section>
  </div>
@stop