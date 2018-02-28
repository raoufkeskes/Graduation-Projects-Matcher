@extends('user.layouts.Masterlayout')

@section('Content')
<div class="row">
                        <div class="col-md-12">

                            <div class="error-container">
                                <div class="error-container">
                                    <div class="error-code"></div>
                                    <div class="error-text">Fin de Procédure<Br>Félicitations !</div>
                                    <div class="error-subtext">{!!$msg!!}
                                    </div>
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                        <strong>Note !<br> </strong>Vérifier constamment votre compte car votre promoteur pourra à tout moment annuler votre promotion .
                                    </div>
                                    
                                </div>  
                            </div>

                        </div>
</div>
@stop






