@if(!is_null($item))
    @foreach($item as $ik => $iv)
        <div class="card boqItem">
            <div class="card-body ">
                <a href="javascript:void(0);" class="btn btn-danger float-right removeItem"><i class="fa fa-trash"></i></a><br /><br />
                <div class="row mb-3 item">
                    <div class="col-md-4 mb-3">
                        <label>Product <span class="mandatory">*</span></label>
                        <input type="hidden" name="boq[{{ $ik }}][boq_item_id]" value="{{ $iv->id }}">
                        <input type="text" name="boq[{{ $ik }}][product]" class="form-control product" data-msg="Please select product" placeholder="Product" data-key="{{ $ik }}" value="{{ !is_null($iv->category) ? $iv->category->product_type : '--' }} - {{ !is_null($iv->grade) ? $iv->grade->grade : '--' }}" readonly required>
                        <input type="hidden" name="boq[{{ $ik }}][product_id]" value="{{ $iv->variation_id }}" class="product_id">
                    </div>
                    <div class="col-md-4">
                        <label>Remaining BOQ Qty</label>
                        <input type="text" name="boq[{{ $ik }}][remaining_boq_qty]" class="form-control" placeholder="Remaining BOQ Qty" value="{{ $iv->remaining_qty }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Unit <span class="mandatory">*</span></label>
                        <input type="text" name="boq[{{ $ik }}][unit]" class="form-control" placeholder="Unit" data-id="{{ $ik }}" value="{{ $iv->unit }}" readonly required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>PO Qty <span class="mandatory">*</span></label>
                        <input type="text" name="boq[{{ $ik }}][po_qty]" class="form-control boqqty boqqty{{ $ik }} width" data-msg="Please enter valid PO qty" placeholder="PO Qty" max="{{ $iv->remaining_qty }}" data-id="{{ $ik }}" max="{{ $iv->qty }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>Rate Per Unit <span class="mandatory">*</span></label>
                        <input type="text" name="boq[{{ $ik }}][rate_per_unit]" class="form-control boqrate boqrate{{ $ik }} width" data-msg="Please enter rate per unit" placeholder="Rate Per Unit" data-id="{{ $ik }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>Freight <span class="mandatory">*</span></label>
                        <input type="text" name="boq[{{ $ik }}][freight]" class="form-control freight freight{{ $ik }} width" data-msg="Please enter freight" placeholder="Rate Per Unit" data-id="{{ $ik }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>Freight Selection <span class="mandatory">*</span></label>
                        <select class="form-control freightOption freightOption{{ $ik }}" name="boq[{{ $ik }}][fright_selection]" required data-msg="Please select Fright" data-id="{{ $ik }}">
                            <option value="">Select Fright</option>
                            <option value="1">(Rate + Freight) x Qty</option>
                            <option value="2">(Rate x Qty) + Freight)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>GST <span class="mandatory">*</span></label>
                        <input type="text" name="boq[{{ $ik }}][gst]" class="form-control gst gst{{ $ik }} width" data-msg="Please enter rate per unit" placeholder="GST" data-id="{{ $ik }}" value="{{ !is_null($iv->category) ? $iv->category->gst : '' }}" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label>Subtotal <span class="mandatory">*</span></label>
                        <input type="text" name="boq[{{ $ik }}][subtotal]" class="form-control boqsubtotal boqsubtotal{{ $ik }} width" data-msg="Please enter subtotal" placeholder="Subtotal" readonly required>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
