<form action="{{ route('admin.client.updateTaxSetting') }}" id="taxSetting" method="post">
	@csrf
	<input type="hidden" name="id" value="{{ $getIntresetData->id }}">
	<div class="form-group mb-3">
        <label>Credit Amount <span class="mandatory">*</span></label>
        <input type="text" name="credit_amount" class="form-control width" id="creditAmount" placeholder="Credit Amount" value="{{ $getIntresetData->credit_amount }}" data-msg="Please enter credit amount" required>
    </div>
    <div class="form-group mb-3">
        <label>Interest Rate <span class="mandatory">*</span></label>
        <input type="text" name="interest_rate" class="form-control width" id="interestRate" placeholder="Interest Rate" value="{{ $getIntresetData->interest_rate }}" data-msg="Please enter interest rate" required>
    </div>
    <div class="form-group mb-3">
        <label>Tolerance <span class="mandatory">*</span></label>
        <input type="text" name="tolerance" class="form-control width" id="tolerance" placeholder="Tolerance" value="{{ $getIntresetData->tolerance }}" data-msg="Please enter tolerance" required>
    </div>
    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
	    Save
	</button>
</form>