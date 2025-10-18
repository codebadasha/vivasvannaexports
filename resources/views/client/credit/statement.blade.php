<div class="row">
    <div class="col-md-5 mb-3">
        <label>Statement <span class="mandatory">*</span></label>
        <input type="file" name="item[{{ $request->key }}][statement]" class="form-control" data-msg="Please upload statement" required>
    </div>
    <div class="col-md-6">
        <label>Bank <span class="mandatory">*</span></label>
        <select class="form-control select2" name="item[{{ $request->key }}][bank]" data-msg="Please select bank" required>
            <option value="">Select Bank</option>
            @forelse(\App\Models\Bank::all() as $bk => $bv)
                <option value="{{ $bv->id }}">{{ $bv->name }}</option>
            @empty 
                <option value="">No Data Found</option>
            @endforelse
        </select>
    </div>
    <div class="col-md-1 mt-4">
        <a href="javascript:void(0);" class="btn btn-danger mt-1 removeRow"><i class="fa fa-trash"></i></a>
    </div>
</div>