<div class="removeBoqItems">
    <div class="card">
        <div class="card-body">
            <a href="javscript:void(0);" class="btn btn-danger float-right removeItem"><i class="fa fa-trash"></i></a><br /><br />
            <div class="row mb-3 item">
                <div class="col-md-3 mb-3">
                    <label>Category <span class="mandatory">*</span></label>
                    <select class="form-control category" name="item[{{ $request->key }}][category_id]" data-msg="Please select category" data-key="{{ $request->key }}" required>
                        <option value="">Select Category</option>
                        @forelse(\App\Models\Product::where('is_active',1)->where('is_delete',0)->get() as $pk => $pv)
                            <option value="{{ $pv->id }}">{{ $pv->product_type }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Variation <span class="mandatory">*</span></label>
                    <select class="form-control variation variation{{ $request->key }}" name="item[{{ $request->key }}][variation]" data-msg="Please select variation" data-key="{{ $request->key }}" required>
                        <option value="">Select Variation</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Qty <span class="mandatory">*</span></label>
                    <input type="text" name="item[{{ $request->key }}][qty]" class="form-control qty qty0 width" data-msg="Please enter qty" placeholder="Qty" data-id="0" required>
                </div>
                <div class="col-md-3">
                    <label>Unit <span class="mandatory">*</span></label>
                    <select class="form-control unit{{ $request->key }}" name="item[{{ $request->key }}][unit]" data-msg="Please select unit" required>
                        <option value="">Select Unit</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>