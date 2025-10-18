<table class="table">
	<tr>
		<td>Sr.no</td>
		<td>Name</td>
		<td>Email</td>
		<td>Mobile</td>
	</tr>
	@if(!is_null($getAuthorizedPerson))
		@foreach($getAuthorizedPerson as $ak => $av)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $av->name }}</td>
				<td>{{ $av->email }}</td>
				<td>{{ $av->mobile }}</td>
			</tr>
		@endforeach
	@endif
</table>