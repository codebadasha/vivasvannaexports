@extends('layouts.client')
@section('title','Edit Profile')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <form class="custom-validation" action="{{ route('client.updateCompanyProfile') }}" method="post" id="editClientCompany" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $detail->id }}" />
            <input type="hidden" name="uuid" id="uuid" value="{{ $detail->uuid }}" />
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label>GSTN <span class="mandatory">*</span></label>
                                <input type="text" name="gstn" class="form-control" id="gstn" maxlength="15" minlength="15" placeholder="GSTN" value="{{ old('gstn', $detail->gstn)  }}" required readonly>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label>PAN Number <span class="mandatory">*</span></label>
                                <input type="text" name="pan_number" maxlength="10" minlength="10" class="form-control" id="panNumber" placeholder="PAN Number" value="{{ old('pan_number', $detail->pan_number)  }}" required readonly>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label>CIN</label>
                                <input type="text" name="cin" class="form-control" id="cin" placeholder="CIN" value="{{ old('cin', $detail->cin) }}" @if(!empty($detail->cin)) readonly @endif>
                            </div>

                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body row">

                                <div class="form-group col-md-4 mb-3">
                                    <label>Company Name <span class="mandatory">*</span></label>
                                    <input type="text" name="company_name" class="form-control" id="companyName" placeholder="Company Name" value="{{ old('company_name', $detail->company_name) }}" required readonly>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Director Name <span class="mandatory">*</span></label>
                                    <input type="text" name="director_name" class="form-control" id="directorName" placeholder="Director Name" value="{{ old('director_name', $detail->director_name) }}" required readonly>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Email ID <span class="mandatory">*</span></label>
                                    <input type="email" name="email" class="form-control" id="emailId" placeholder="Email ID " value="{{ old('email', $detail->email) }}" required readonly>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Contact number<span class="mandatory">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control numeric" id="mobileNumber" placeholder="Mobile Number" value="{{ old('mobile_number', $detail->mobile_number) }}" required readonly>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>State <span class="mandatory">*</span></label>
                                    <select class="form-control" name="state_id" required disabled>
                                        <option value="">Select State</option>
                                        @forelse(\App\Models\State::all() as $sk => $sv)
                                        <option value="{{ $sv->id }}" {{ old('state_id', $detail->state_id) == $sv->id ? 'selected' : '' }}>{{ $sv->name }}</option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                    <input type="hidden" name="state_id" class="form-control numeric" placeholder="Mobile Number" value="{{ $detail->state_id }}" required>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Company Turnover <span class="mandatory">*</span></label>
                                    @php $turnover = old('turnover', $detail->turnover); @endphp
                                    <select class="form-control select2" name="turnover" id="turnover" required disabled>
                                        <option value="">Select Turnover</option>
                                        <option value="0" {{ $turnover == '0' ? 'selected' : '' }}>Below 50cr</option>
                                        <option value="1" {{ $turnover == '1' ? 'selected' : '' }}>Between 50cr to 150cr</option>
                                        <option value="2" {{ $turnover == '2' ? 'selected' : '' }}>Between 150cr to 250cr</option>
                                        <option value="3" {{ $turnover == '3' ? 'selected' : '' }}>Between 250cr to 500cr</option>
                                        <option value="4" {{ $turnover == '4' ? 'selected' : '' }}>Between 500cr to 1000cr</option>
                                        <option value="5" {{ $turnover == '5' ? 'selected' : '' }}>Above 1000cr</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Registered Address <span class="mandatory">*</span></label>
                                    <textarea class="form-control" name="address" placeholder="Registered Address" required readonly>{{ old('address', $detail->address) }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="authorizedPerson">
                                    <label>Authorized Person <span class="mandatory">*</span></label>
                                    @php
                                    $authorized = old('authorized', $detail->authorized ?? []);
                                    if (empty($authorized)) {
                                    $authorized = [['name' => '', 'email' => '', 'mobile' => '']];
                                    }
                                    @endphp
                                    @foreach($authorized as $ak => $av)
                                    <div class="row mb-3 authorized">
                                        <div class="col-md-4">
                                            <label>Name <span class="mandatory">*</span></label>
                                            <input type="text" name="authorized[{{ $ak }}][name]" class="form-control"
                                                value="{{ $av['name'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email <span class="mandatory">*</span></label>
                                            <input type="email" name="authorized[{{ $ak }}][email]" class="form-control"
                                                value="{{ $av['email'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Mobile Number <span class="mandatory">*</span></label>
                                            <input type="text" name="authorized[{{ $ak }}][mobile]" maxlength="10" minlength="10"
                                                class="form-control numeric"
                                                value="{{ $av['mobile'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-1 mt-4">
                                            @if($loop->first)
                                            <a href="javascript:void(0);" class="btn btn-primary mt-1 addAuthorizedPerson" data-id="1">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            @else
                                            <a href="javascript:void(0);" class="btn btn-danger mt-1 removeAuthorizedPerson">
                                                <i class="fa fa-minus"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="contactPerson">
                                    <label>Contact Person <span class="mandatory">*</span></label>
                                    @php
                                    $contactPersons = old('contact', $detail->contact ?? []);
                                    if (empty($contactPersons)) {
                                    $contactPersons = [['name' => '', 'email' => '', 'mobile' => '']];
                                    }
                                    @endphp
                                    @foreach($contactPersons as $ak => $av)
                                    <div class="row mb-3 contactperson">
                                        <div class="col-md-4">
                                            <label>Name <span class="mandatory">*</span></label>
                                            <input type="text" name="contact[{{ $ak }}][name]" class="form-control" data-msg="Please enter name" placeholder="Name" value="{{ $av['name'] }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email <span class="mandatory">*</span></label>
                                            <input type="email" name="contact[{{ $ak }}][email]" class="form-control" data-msg="Please enter email" placeholder="Email" value="{{ $av['email'] }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Mobile Number <span class="mandatory">*</span></label>
                                            <input type="text" name="contact[{{ $ak }}][mobile]" maxlength="10" minlength="10" class="form-control numeric" data-msg="Please enter mobile number" maxlength="10" minlength="10" placeholder="Mobile Number" value="{{ $av['mobile'] }}" required>
                                        </div>
                                        <div class="col-md-1 mt-4">
                                            @if($loop->first)
                                            <a href="javascript:void(0);" class="btn btn-primary mt-1 addContactPerson" data-id="1">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            @else
                                            <a href="javascript:void(0);" class="removeContactPerson btn btn-danger mt-1">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="button-items">
                                    <center>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                            Update
                                        </button>
                                        <a href="{{ route('admin.client.index') }}" class="btn btn-danger waves-effect">
                                            Cancel
                                        </a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    function addAuthorizedPerson() {
        const index = $(".authorized").length;

        const newRow = `
        <div class="row mb-3 authorized">
            <div class="col-md-4">
                <label>Name <span class="mandatory">*</span></label>
                <input type="text" name="authorized[${index}][name]" class="form-control authName" placeholder="Authorized Name" required>
            </div>
            <div class="col-md-4">
                <label>Email <span class="mandatory">*</span></label>
                <input type="email" name="authorized[${index}][email]" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-md-3">
                <label>Mobile Number <span class="mandatory">*</span></label>
                <input type="text" name="authorized[${index}][mobile]" class="form-control numeric" maxlength="10" minlength="10" placeholder="Mobile Number" required>
            </div>
            <div class="col-md-1 mt-4">
                <a href="javascript:void(0);" class="btn btn-danger mt-1 removeAuthorizedPerson">
                    <i class="fa fa-minus"></i>
                </a>
            </div>
        </div>`;

        $(".authorizedPerson").append(newRow);
    }

    /**
     * Remove authorized person row
     * @param {HTMLElement} el
     */
    function removeAuthorizedPerson(el) {
        $(el).closest(".authorized").remove();
    }

    /* ------------------------------------------------------------------
       Contact Person Management
    -------------------------------------------------------------------*/

    /**
     * Add new contact person row
     */
    function addContactPerson() {
        const index = $(".contactperson").length;

        const newRow = `
        <div class="row mb-3 contactperson">
            <div class="col-md-4">
                <label>Name <span class="mandatory">*</span></label>
                <input type="text" name="contact[${index}][name]" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-4">
                <label>Email <span class="mandatory">*</span></label>
                <input type="email" name="contact[${index}][email]" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-md-3">
                <label>Mobile Number <span class="mandatory">*</span></label>
                <input type="text" name="contact[${index}][mobile]" class="form-control numeric" maxlength="10" minlength="10" placeholder="Mobile Number" required>
            </div>
            <div class="col-md-1 mt-4">
                <a href="javascript:void(0);" class="btn btn-danger mt-1 removeContactPerson">
                    <i class="fa fa-minus"></i>
                </a>
            </div>
        </div>`;

        $(".contactPerson").append(newRow);
    }

    /**
     * Remove contact person row
     * @param {HTMLElement} el
     */
    function removeContactPerson(el) {
        $(el).closest(".contactperson").remove();
    }

    /* ------------------------------------------------------------------
       Event Bindings
    -------------------------------------------------------------------*/
    $(document).on("click", ".addAuthorizedPerson", addAuthorizedPerson);
    $(document).on("click", ".removeAuthorizedPerson", function() {
        removeAuthorizedPerson(this);
    });

    $(document).on("click", ".addContactPerson", addContactPerson);
    $(document).on("click", ".removeContactPerson", function() {
        removeContactPerson(this);
    });
</script>

@endsection