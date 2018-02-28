@if ($errors->has($data))
	<div class="error-msg">{{ $errors->first($data) }}</div>
@endif

