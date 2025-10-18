@extends('layouts.client')
@section('title','Apply For Credit')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Apply For Credit</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">All POs</a></li>
                            <li class="breadcrumb-item active">Apply For Credit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <div class="row">   
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                        </div>
                        <h3 class="card-title">Upload 6 month statement</h3><br />
                        <div class="statement">
                            @if(!is_null($creditRequest->statement))
                                @foreach($creditRequest->statement as $sk => $sv)
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label>Statement <span class="mandatory">*</span></label>
                                            <input type="file" name="item[0][statement]" class="form-control" data-msg="Please upload statement" required>
                                            <a href="{{ asset('uploads/bank_statement') }}/{{ $sv->bank_statement }}" target="_blank">View File</a>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Bank <span class="mandatory">*</span></label>
                                            <select class="form-control select2" name="item[0][bank]" data-msg="Please select bank" disabled required>
                                                <option value="">Select Bank</option>
                                                @forelse(\App\Models\Bank::all() as $bk => $bv)
                                                    <option value="{{ $bv->id }}" {{ $bv->id == $sv->bank_id ? 'selected' : '' }}>{{ $bv->name }}</option>
                                                @empty 
                                                    <option value="">No Data Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Balance sheet of last three years</h3><br />
                        <div class="row">
                            @if(!is_null($creditRequest->sheet))
                                @foreach($creditRequest->sheet as $sk => $sv)
                                    <div class="col-md-12 mb-3">
                                        <label>{{ $sv->year }} <span class="mandatory">*</span></label>
                                        <input type="file" name="" class="form-control" data-msg="Please upload statement" required>
                                        <a href="{{ asset('uploads/balance_sheet') }}/{{ $sv->file }}" target="_blank">View File</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
