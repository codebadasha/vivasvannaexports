@extends('layouts.guest')
@section('title','Add Client Company')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Company Register</h4>
                </div>
            </div>
        </div>

        <form class="custom-validation" id="addClientCompany" action="{{ route('company.submit') }}" method="post" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label>GSTN <span class="mandatory">*</span></label>
                                <input type="text" name="gstn" class="form-control" id="gstn" maxlength="15" minlength="15"
                                    placeholder="GSTN" required value="{{ old('gstn') }}" autocomplete="off">
                                <span for="icon" id="gst-loader" class="p-viewer spinner-border text-info"
                                    style="width: 1.5rem;height: 1.5rem;border-width: 0.42em;margin-top: -30px; display: none;"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="company-details" style="{{ old('gstn') ? '' : 'display:none;' }}">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body row">
                                <div class="form-group col-md-4 mb-3">
                                    <label>PAN Number <span class="mandatory">*</span></label>
                                    <input type="hidden" name="token" value="{{ old('token', $token) }}">
                                    <input type="hidden" name="msme_register" id="msme_register">
                                    <input type="text" name="pan_number" maxlength="10" minlength="10" class="form-control"
                                        id="panNumber" placeholder="PAN Number" required readonly
                                        value="{{ old('pan_number') }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>CIN</label>
                                    <input type="text" name="cin" class="form-control" id="cin" placeholder="CIN"
                                        readonly value="{{ old('cin') }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Company Name <span class="mandatory">*</span></label>
                                    <input type="text" name="company_name" class="form-control" id="companyName"
                                        placeholder="Director Name" required readonly value="{{ old('company_name') }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Director Name <span class="mandatory">*</span></label>
                                    <select name="director_name" class="form-control" id="directorName" required>
                                        <option value="">Select Director</option>
                                    </select>
                                    <input type="hidden" name="directorsList" id="directorsList" value="{{ old('directorsList') }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Email ID <span class="mandatory">*</span></label>
                                    <input type="email" name="email_id" class="form-control" id="email" placeholder="Email ID "
                                        required readonly value="{{ old('email_id') }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Contact number <span class="mandatory">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control numeric" id="mobileNumber"
                                        placeholder="Contact number" required readonly value="{{ old('mobile_number') }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>State <span class="mandatory">*</span></label>
                                    @php $oldState = old('state_id'); @endphp
                                    <select class="form-control select2" name="state_id" id="state_id" required disabled>
                                        <option value="">Select State</option>
                                        @forelse(\App\Models\State::all() as $sk => $sv)
                                        <option value="{{ $sv->id }}" {{ $oldState == $sv->id ? 'selected' : '' }}>
                                            {{ $sv->name }}
                                        </option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                    <input type="hidden" name="state_id" value="{{ $oldState }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Password <span class="mandatory">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                                        <span class="input-group-text toggle-password" style="cursor:pointer;">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Confirm Password <span class="mandatory">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                                        <span class="input-group-text toggle-password" style="cursor:pointer;">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Company Turnover <span class="mandatory">*</span></label>
                                    @php $turnover = old('turnover'); @endphp
                                    <select class="form-control select2" name="turnover" id="turnover" required>
                                        <option value="">Select Turnover</option>
                                        <option value="0" {{ $turnover == '0' ? 'selected' : '' }}>Below 50cr</option>
                                        <option value="1" {{ $turnover == '1' ? 'selected' : '' }}>Between 50cr to 150cr</option>
                                        <option value="2" {{ $turnover == '2' ? 'selected' : '' }}>Between 150cr to 250cr</option>
                                        <option value="3" {{ $turnover == '3' ? 'selected' : '' }}>Between 250cr to 500cr</option>
                                        <option value="4" {{ $turnover == '4' ? 'selected' : '' }}>Between 500cr to 1000cr</option>
                                        <option value="5" {{ $turnover == '5' ? 'selected' : '' }}>Above 1000cr</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-8 mb-3">
                                    <label>Registered Address <span class="mandatory">*</span></label>
                                    <textarea class="form-control" name="address" placeholder="Registered Address"
                                        required readonly>{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Authorized Person --}}
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="authorizedPerson">
                                    <label>Authorized Person <span class="mandatory">*</span></label>
                                    <span class="float-right">
                                        <input type="checkbox" name="same_as_director" value="1" id="sameAsDirector"
                                            {{ old('same_as_director') ? 'checked' : '' }}>&nbsp;&nbsp;Same as above
                                    </span>

                                    @php
                                    $authorized = old('authorized', [['name'=>'','email'=>'','mobile'=>'']]);

                                    @endphp
                                    @foreach($authorized as $ak => $av)
                                    <div class="row mb-3 authorized">
                                        <div class="col-md-4">
                                            <label>Name <span class="mandatory">*</span></label>
                                            <input type="name" name="authorized[{{ $ak }}][name]" class="form-control"
                                                value="{{ old("authorized.$ak.name") }}" @if($loop->first && old('same_as_director')) readonly @endif required placeholder="Enter Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email <span class="mandatory">*</span></label>
                                            <input type="email" name="authorized[{{ $ak }}][email]" class="form-control"
                                                value="{{ old("authorized.$ak.email") }}" @if($loop->first && old('same_as_director')) readonly @endif required placeholder="Enter Email">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Mobile Number <span class="mandatory">*</span></label>
                                            <input type="text" name="authorized[{{ $ak }}][mobile]"
                                                class="form-control numeric" maxlength="10" minlength="10"
                                                value="{{ old("authorized.$ak.mobile") }}" @if($loop->first && old('same_as_director')) readonly @endif required placeholder="Enter Mobile Number">
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

                    {{-- Contact Person --}}
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="contactPerson">
                                    <label>Contact Person <span class="mandatory">*</span></label>
                                    @php
                                    $contacts = old('contact', [['name'=>'','email'=>'','mobile'=>'']]);
                                    @endphp
                                    @foreach($contacts as $ck => $cv)
                                    <div class="row mb-3 contactperson">
                                        <div class="col-md-4">
                                            <label>Name <span class="mandatory">*</span></label>
                                            <input type="text" name="contact[{{ $ck }}][name]" class="form-control"
                                                value="{{ old("contact.$ck.name") }}" required placeholder="Enter Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Email <span class="mandatory">*</span></label>
                                            <input type="email" name="contact[{{ $ck }}][email]" class="form-control"
                                                value="{{ old("contact.$ck.email") }}" required placeholder="Enter Email">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Mobile Number <span class="mandatory">*</span></label>
                                            <input type="text" name="contact[{{ $ck }}][mobile]"
                                                class="form-control numeric" maxlength="10" minlength="10"
                                                value="{{ old("contact.$ck.mobile") }}" required placeholder="Enter Mobile Number">
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

                    {{-- Buttons --}}
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="button-items">
                                    <center>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1"
                                            name="btn_submit" value="save">Registere</button>
                                    </center>
                                </div>
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
<script src="{{ asset('js/page/add_company.js') }}"></script>
<script>
    $(document).ready(function() {
        window.checkGstURL = `{{ route('company.gst.check') }}`;

        $(document).on("click", ".toggle-password", function() {
            let input = $(this).siblings("input");
            let icon = $(this).find("i");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
    });
</script>
@if(old('directorsList'))
<script>
    const list = @json(json_decode(old('directorsList'), true));
    const selected = "{{ old('director_name') }}";
    populateDirectorDropdown(list, selected);
</script>
@endif
@endsection