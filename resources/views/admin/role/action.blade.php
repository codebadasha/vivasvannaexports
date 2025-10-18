@if(is_array($request->role))
	@foreach($request->role as $rk => $rv)
		@php
			$action = config('constants.module')[$rv];
		@endphp

		<div class="mb-3 action_{{ $rv }}">
		    <label class="d-block mb-3">{{ $action['name'] }}</label>
		    @foreach($action['action'] as $ak => $av)
			    <div class="form-check form-check-inline mb-3">
			        <input class="form-check-input" type="checkbox" id="{{ $ak }}-{{ $rv }}" value="{{ $ak }}" name="role[{{ $rv }}][]" {{ $av['selected'] ? 'checked' : ''}} @if($av['selected']) onclick="return false" @endif>
			        <label class="form-check-label" for="{{ $ak }}-{{ $rv }}">
			            {{ $av['name'] }}
			        </label>
			    </div>
			@endforeach
		</div>
	@endforeach
@else
	@php
		$action = config('constants.module')[$request->role];
	@endphp

	<div class="mb-3 action_{{ $request->role }}">
	    <label class="d-block mb-3">{{ $action['name'] }}</label>
	    @foreach($action['action'] as $ak => $av)
		    <div class="form-check form-check-inline mb-3">
		        <input class="form-check-input" type="checkbox" id="{{ $ak }}-{{ $request->role }}" value="{{ $ak }}" name="role[{{ $request->role }}][]" {{ $av['selected'] ? 'checked' : ''}} @if($av['selected']) onclick="return false" @endif>
		        <label class="form-check-label" for="{{ $ak }}-{{ $request->role }}">
		            {{ $av['name'] }}
		        </label>
		    </div>
		@endforeach
	</div>
@endif
