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
                                    @error('company_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Director Name <span class="mandatory">*</span></label>
                                    <select name="director_name" class="form-control" id="directorName" required>
                                        <option value="">Select Director</option>
                                    </select>
                                    @error('director_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <input type="hidden" name="directorsList" id="directorsList" value="{{ old('directorsList') }}">
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Email ID <span class="mandatory">*</span></label>
                                    <input type="email" name="email_id" class="form-control" id="email" placeholder="Email ID "
                                        required value="{{ old('email_id') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label>Contact number <span class="mandatory">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control numeric" id="mobileNumber"
                                        placeholder="Contact number" required value="{{ old('mobile_number') }}">
                                    @error('mobile_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
                                    @error('state_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <input type="hidden" name="state_id" value="{{ $oldState }}">
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
                                    @error('turnover')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-8 mb-3">
                                    <label>Registered Address <span class="mandatory">*</span></label>
                                    <textarea class="form-control" name="address" placeholder="Registered Address"
                                        required readonly>{{ old('address') }}</textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    
                   {{-- Contact Person --}}
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="contactPerson">
                                    @php
                                        $contactPersons = old('contact', [[
                                                            'name' => '',
                                                            'email' => '',
                                                            'mobile' => '',
                                                            'phone' => '',
                                                            'designation' => ''
                                                            ]]
                                                        );
                                        
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <label class="mb-0">Contact Person <span class="mandatory">*</span></label>
                                            @error("contact")
                                                <br>
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>            
                                        <span>
                                            <input type="checkbox" name="same_as_director" value="1" id="sameAsDirector"
                                                {{ old('same_as_director') ? 'checked' : '' }}>
                                            &nbsp;&nbsp;Same as above
                                        </span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle" id="contactPersonTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="20%">Name <span class="mandatory">*</span></th>
                                                    <th width="25%">Email <span class="mandatory">*</span></th>
                                                    <th>Mobile <span class="mandatory">*</span></th>
                                                    <th>Phone</th>
                                                    <th>Designation</th>
                                                    <th width="5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($contactPersons as $ak => $av)
                                                <tr class="contactperson">
                                                    <td>
                                                        <input type="text" name="contact[{{ $ak }}][name]" class="form-control {{ !empty($av['contact_person_id']) ? 'contact-editable' : '' }}" placeholder="Name" value="{{ $av['name'] ?? '' }}" required>
                                                        @error("contact.$ak.name")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="email" name="contact[{{ $ak }}][email]" class="form-control {{ !empty($av['contact_person_id']) ? 'contact-editable' : '' }}" placeholder="Email" value="{{ $av['email'] ?? '' }}" required>
                                                        @error("contact.$ak.email")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="contact[{{ $ak }}][mobile]" class="form-control numeric {{ !empty($av['contact_person_id']) ? 'contact-editable' : '' }}" maxlength="10" minlength="10" placeholder="Mobile" value="{{ $av['mobile'] ?? '' }}" required>
                                                        @error("contact.$ak.mobile")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="contact[{{ $ak }}][phone]" class="form-control numeric {{ !empty($av['contact_person_id']) ? 'contact-editable' : '' }}" maxlength="10" minlength="10" placeholder="Phone" value="{{ $av['phone'] ?? '' }}">
                                                        @error("contact.$ak.phone")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="contact[{{ $ak }}][designation]" class="form-control {{ !empty($av['contact_person_id']) ? 'contact-editable' : '' }}" placeholder="Designation" value="{{ $av['designation'] ?? '' }}">
                                                        @error("contact.$ak.designation")
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="text-center">
                                                        @if(!$loop->first)
                                                            <button type="button" class="btn btn-danger btn-sm contact-delete-btn" data-id="{{ $av['id'] ?? '' }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-3 text-left">
                                        <button type="button" class="btn btn-primary addContactPerson">
                                            <i class="fa fa-plus"></i> Add Contact
                                        </button>
                                    </div>
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