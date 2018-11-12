<form action="{{ $action }}" method="{{ $method == 'GET' ? "Get" : "POST" }}" class="{{ $class }}" id="{{ $id }}" enctype="multipart/form-data">
@if($method != 'GET' && $method != 'POST')
	<input type="hidden" name="_method" value="{{ $method }}">
@endif
	{{ csrf_field() }}

	@if (count($errors) > 0)
	<div class="form-group">
		<div class="alert alert-danger" role="alert">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
		</div>
	</div>
	@endif
	
	{{ $slot }}
</form>
	
	