
<table class="table">
	<tr>
		<td>Sr.no</td>
		<td>Name</td>
		<td>Email</td>
		<td>Mobile</td>
	</tr>
	@if(!is_null($getCompanyAuthorizedPerson))
		@foreach($getCompanyAuthorizedPerson as $ak => $av)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $av->name }}</td>
				<td>{{ $av->email }}</td>
				<td>{{ $av->mobile }}</td>
			</tr>
		@endforeach
	@endif
</table>

<h5>Cotact Person</h5>

<table class="table">
	<tr>
		<td>Sr.no</td>
		<td>Name</td>
		<td>Email</td>
		<td>Mobile</td>
	</tr>
	@if(!is_null($getClientCompanyContact))
		@foreach($getClientCompanyContact as $ak => $av)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $av->name }}</td>
				<td>{{ $av->email }}</td>
				<td>{{ $av->mobile }}</td>
			</tr>
		@endforeach
	@endif
</table>

