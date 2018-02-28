@php
	  $olddestinea =  is_null(old('destinea')) ? "" : implode(",", old('destinea') ) ;

@endphp


<div class="form-group">

    <label class="col-md-3 control-label">Destiné a :</label>
	<div class="col-md-9 col-xs-12">                                            
			    <select multiple class="form-control select" id="destinea" 
			    data-old="{{ $olddestinea }}" data-destinea='{{ isset($destinea) ? $destinea :"" }}'
			     name="destinea[]" title="Aucune specialité n'est selectionnée" >
			             <optgroup label="Licence">
						    @foreach ($specialites['Licence'] as $specialite)
			                        <option  data-subtext="{{$specialite->label}}">{{$specialite->spec}}</option>
			                @endforeach
						  </optgroup>
						  <optgroup label="Master">
						    @foreach ($specialites['Master'] as $specialite)
			                        <option data-subtext="{{$specialite->label}}">{{$specialite->spec}}</option>
			                @endforeach
						  </optgroup> 
			    </select>
    </div>
</div>
 