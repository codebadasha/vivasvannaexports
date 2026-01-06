<table class="table">
	<tr>
		<td>Sr. No</td>
		<td>Product</td>
		<td>Ordered Qty</td>
		<td>Fulfilled Qty</td>
	</tr>
	@if(!is_null($boq->item))
		@foreach($boq->item as $bk => $bv)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ !is_null($bv->product) ? $bv->product->name : '--'}}</td>
				<td>{{ $bv->qty }} - {{ $bv->unit }}</td>
				<td>Coming Soon</td>
			</tr>
		@endforeach
	@endif
</table>