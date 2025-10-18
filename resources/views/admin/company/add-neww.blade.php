@extends('layouts.admin')
@section('title','Add Client Company')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Client Company</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Client Company List</a></li>
                            <li class="breadcrumb-item active">Add Client Company</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <form class="custom-validation"
            action="{{ route('admin.client.store') }}"
            method="post" id="addClientCompany"
            enctype="multipart/form-data">

            @csrf

            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="card">
                        <div style="padding-right:1.25rem; padding-top:1.25rem;">
                            <h6 class="mb-0" style="color:red;float:right;">* is mandatory</h6>
                        </div>

                        <!-- STEP 1: Basic Details -->
                        <div class="step" data-step="1">
                            <div class="card-body pb-0">
                                <div class="form-group mb-3">
                                    <label>Company Name <span class="mandatory">*</span></label>
                                    <input type="text" name="company_name" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Director Name <span class="mandatory">*</span></label>
                                    <input type="text" name="director_name" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Contact number <span class="mandatory">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control numeric" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Email ID <span class="mandatory">*</span></label>
                                    <input type="email" name="email_id" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Assign Investors</label>
                                    <select class="form-control select2" name="investor[]" multiple>
                                        @foreach(\App\Models\Investor::where('is_active',1)->where('is_delete',0)->get() as $iv)
                                        <option value="{{ $iv->id }}">{{ $iv->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>

                        <!-- STEP 2: GST, PAN & CIN -->
                        <div class="step" data-step="2" style="display:none;">
                            <div class="card-body pb-0">
                                <div class="form-group mb-3">
                                    <label>GSTN <span class="mandatory">*</span></label>
                                    <input type="text" name="gstn" id="gstn" maxlength="15" minlength="15" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>PAN Number <span class="mandatory">*</span></label>
                                    <input type="text" name="pan_number" id="panNumber" maxlength="10" minlength="10" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>CIN <span class="mandatory">*</span></label>
                                    <input type="text" name="cin" class="form-control" required>
                                </div>
                            </div>
                        </div>


                        <!-- STEP 3: Authorized & Contact Person -->
                        <div class="step" data-step="3" style="display:none;">

                            <div class="card mb-0">
                                <div class="card-header" style="margin-top:1.25rem;">
                                    <h6 class="header-title mb-0">Authorized Person</h6>
                                </div>
                                <div class="card-body authorizedPerson">
                                    <div class="row authorized">

                                        <div class="col-md-4">
                                            <label>Name <span class="mandatory">*</span></label>
                                            <input type="text" name="authorized[0][name]" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email <span class="mandatory">*</span></label>
                                            <input type="email" name="authorized[0][email]" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Mobile Number <span class="mandatory">*</span></label>
                                            <input type="text" name="authorized[0][mobile_number]" class="form-control numeric" maxlength="10" minlength="10" required>
                                        </div>
                                        <div class="col-md-1 mt-4">
                                            <a href="javascript:void(0);" class="btn btn-primary addAuthorizedPerson " data-id="1"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mb-0">
                                <div class="card-header" style="margin-top:1.25rem;">
                                    <h6 class="header-title mb-0">Contact Personn</h6>
                                </div>
                                <div class="card-body contactPerson">
                                    <div class="row contactperson">
                                        <div class="col-md-4">
                                            <label>Name <span class="mandatory">*</span></label>
                                            <input type="text" name="contact[0][name]" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email <span class="mandatory">*</span></label>
                                            <input type="email" name="contact[0][email]" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Mobile Number <span class="mandatory">*</span></label>
                                            <input type="text" name="contact[0][mobile_number]" class="form-control numeric" maxlength="10" minlength="10" required>
                                        </div>
                                        <div class="col-md-1 mt-4">
                                            <a href="javascript:void(0);" class="btn btn-primary addContactPerson" data-id="1"><i class="fa fa-plus"></i></a>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Stepper Navigation -->
                        <hr>
                        <div class="m-3 mt-0 text-end">
                            <button type="button" id="nextStep" class="btn btn-primary">Next</button>
                            <button type="submit" id="submitForm" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/page/add_company.js') }}"></script>
<script src="{{ asset('js/page/comman/stepper.js') }}"></script>
<script>
    $(document).on('click', '.addAuthorizedPerson', function() {
        var id = $(this).data('id');

        var html = '<div class="row mt-3 authorized"><div class="col-md-4"><label>Name <span class="mandatory">*</span></label><input type="text" name="authorized[' + id + '][name]" class="form-control" data-msg="Please enter name" placeholder="Name" required></div><div class="col-md-4"><label>Email <span class="mandatory">*</span></label><input type="email" name="authorized[' + id + '][email]" class="form-control" data-msg="Please enter email" placeholder="Email" required></div><div class="col-md-3"><label>Mobile Number <span class="mandatory">*</span></label><input type="text" name="authorized[' + id + '][mobile_number]" class="form-control numeric" maxlength="10" minlength="10" data-msg="Please enter mobile number" placeholder="Mobile Number" required></div><div class="col-md-1 mt-4"><a href="javascript:void(0);" class="removeAuthorizedPerson btn btn-danger mt-1"><i class="fa fa-trash"></i></a></div></div>';

        $('.authorizedPerson').append(html);
        $('.addAuthorizedPerson').data('id', ++id);
    })
    $(document).on('click', '.removeAuthorizedPerson', function() {
        $(this).closest('.authorized').remove();
    })

    $(document).on('click', '.addContactPerson', function() {
        var id = $(this).data('id');

        var html = '<div class="row mt-3 contactperson"><div class="col-md-4"><label>Name <span class="mandatory">*</span></label><input type="text" name="contact[' + id + '][name]" class="form-control" data-msg="Please enter name" placeholder="Name" required></div><div class="col-md-4"><label>Email <span class="mandatory">*</span></label><input type="email" name="contact[' + id + '][email]" class="form-control" data-msg="Please enter email" placeholder="Email" required></div><div class="col-md-3"><label>Mobile Number <span class="mandatory">*</span></label><input type="text" name="contact[' + id + '][mobile_number]" class="form-control numeric" maxlength="10" minlength="10" data-msg="Please enter mobile number" placeholder="Mobile Number" required></div><div class="col-md-1 mt-4"><a href="javascript:void(0);" class="removeContactPerson btn btn-danger mt-1"><i class="fa fa-trash"></i></a></div></div>';

        $('.contactPerson').append(html);
        $('.addContactPerson').data('id', ++id);
    })
    $(document).on('click', '.removeContactPerson', function() {
        $(this).closest('.contactperson').remove();
    })
</script>
@endsection