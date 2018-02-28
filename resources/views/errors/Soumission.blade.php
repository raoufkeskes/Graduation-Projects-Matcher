@extends('user.layouts.Masterlayout')

@php
    $type = strtolower( Auth::user()->userable_type ) ;
@endphp
@section('Content')
<div class="row">
                        <div class="col-md-12">

                            <div class="error-container">
                                <div class="error-container">
                                    <div class="error-code"></div>
                                    <div class="error-text">DATE LIMITE ! <Br>Période de Soumission</div>
                                    <div class="error-subtext">Vous êtes en Periode de Soumission <br> qui débute le {{$Date_debut}} et se termine le {{$Date_fin}} . <Br>
                                    {!! $msg !!}</div>
                                    <div class="error-actions">                                
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-success btn-block btn-lg" onClick="document.location.href = '/{{$type}}/posts/create';">Proposer un sujet</button>

                                            </div>
                                        </div>                                
                                    </div>
                                    
                                </div>  
                            </div>

                        </div>
</div>
@stop






