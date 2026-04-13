@extends('layouts.admin')
@section('title','Edit Client Company')
@section('content')
    <style>
        .error-text {
            color: red;
            font-size: 12px;
        }
        .is-invalid {
            border: 1px solid red !important;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Edit Client Company</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Supplier Company List</a></li>
                                <li class="breadcrumb-item active">Edit Client Company</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form class="custom-validation" action="{{ route('admin.client.update') }}" method="post" id="editClientCompany" enctype="multipart/form-data">
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
                                    <input type="text" name="cin" class="form-control" id="cin"
                                        placeholder="CIN"
                                        value="{{ old('cin', $detail->cin) }}"
                                        @if(!empty($detail->cin)) readonly @endif>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body row">

                                    <div class="form-group col-md-4 mb-3">
                                        <label>Company Name <span class="mandatory">*</span></label>
                                        <input type="text" name="company_name" class="form-control" id="companyName" placeholder="Company Name" value="{{ old('company_name', $detail->company_name) }}" required @if(!empty($detail->company_name)) readonly @endif>
                                        @error('company_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label>Director Name<span class="mandatory">*</span></label>
                                        <input type="text" name="director_name" class="form-control" id="directorName" placeholder="Director Name" value="{{ old('director_name', $detail->director_name) }}" required >
                                        @error('director_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label>Email ID <span class="mandatory">*</span></label>
                                        <input type="email" name="email" class="form-control" id="emailId" placeholder="Email ID " value="{{ old('email', $detail->email) }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label>Contact number<span class="mandatory">*</span></label>
                                        <input type="text" name="mobile_number" class="form-control numeric" id="mobileNumber" placeholder="Mobile Number" value="{{ old('mobile_number', $detail->mobile_number) }}" minlength="10" maxlength="10" required >
                                        @error('mobile_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label>State <span class="mandatory">*</span></label>
                                        <select class="form-control" name="state_id" required >
                                            <option value="">Select State</option>
                                            @forelse(\App\Models\State::all() as $sk => $sv)
                                            <option value="{{ $sv->id }}" {{ old('state_id', $detail->state_id) == $sv->id ? 'selected' : '' }}>{{ $sv->name }}</option>
                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                        @error('state_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label>Company Turnover <span class="mandatory">*</span></label>
                                        @php $turnover = old('turnover', $detail->turnover); @endphp
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

                                    <div class="form-group col-md-12 mb-3">
                                        <label>Registered Address <span class="mandatory">*</span></label>
                                        <textarea class="form-control" name="address" placeholder="Registered Address" required >{{ old('address', $detail->address) }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="contactPerson">
                                        @php
                                            $contactPersons = old('contact');
                                            if (!$contactPersons) {
                                                $contactPersons = $detail->contact->toArray();
                                                if (count($contactPersons) == 0) {
                                                    $contactPersons = [[
                                                        'id' => '',
                                                        'contact_person_id' => '',
                                                        'name' => '',
                                                        'email' => '',
                                                        'mobile' => '',
                                                        'phone' => '',
                                                        'designation' => ''
                                                    ]];
                                                }
                                            }
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <label class="mb-0">Contact Person <span class="mandatory">*</span></label>
                                                @error("contact")
                                                    <br>
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            @if(!empty($contactPersons[0]['id']))
                                            <span>
                                                <input type="checkbox" name="same_as_director" value="1" id="sameAsDirector"
                                                    {{ old('same_as_director') ? 'checked' : '' }}>
                                                &nbsp;&nbsp;Same as above
                                            </span>
                                            @endif
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
                                                    <tr class="contactperson" data-zoho-id="{{ $av['contact_person_id'] }}">
                                                        <td>
                                                            <input type="hidden" name="contact[{{ $ak }}][status]" class="status" value="{{ empty($av['contact_person_id']) ? 'add' : '' }}">
                                                            <input type="hidden" name="contact[{{ $ak }}][contact_person_id]"  value="{{ $av['contact_person_id'] ?? '' }}">
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
                                                            <button type="button" class="btn btn-danger btn-sm contact-delete-btn" data-id="{{ $av['id'] ?? '' }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
        $("#editClientCompany").on("submit", function (e) {

            let emails = [];
            let mobiles = [];
            let hasError = false;

            let companyEmail = $("#emailId").val();
            let companyMobile = $("#mobileNumber").val();

            $(".contactperson").each(function () {

                let email = $(this).find("input[name*='[email]']").val();
                let mobile = $(this).find("input[name*='[mobile]']").val();

                // Email duplicate
                if (emails.includes(email) || email === companyEmail) {
                    toastr.error("Duplicate email found: " + email);
                    hasError = true;
                    return false;
                }

                // Mobile duplicate
                if (mobiles.includes(mobile) || mobile === companyMobile) {
                    toastr.error("Duplicate mobile found: " + mobile);
                    hasError = true;
                    return false;
                }

                emails.push(email);
                mobiles.push(mobile);
            });

            if (hasError) {
                e.preventDefault();
            }
        });
       
    </script>

    <script>
        $(document).on('click', '.contact-delete-btn', function () {
            const btn = $(this);
            const row = btn.closest('tr');
            const id = btn.data('id');
            const status = row.find(".status").val();
            let total = $('#contactPersonTable tbody tr').length;

            if (total <= 1) {
                toastr.error("At least one contact required.");
                return;
            }

            if(!id){
                row.remove();
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    // Disable button and show loading
                    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: "{{ route('admin.client.deleteContactPersons') }}",
                        type: 'POST',
                        data: { 
                            id: id, 
                            _token: $('meta[name="csrf-token"]').attr('content') 
                        },
                        success: function (res) {
                            if (res.status) {
                                toastr.success(res.message || "Contact has been deleted successfully");

                                // Remove row with animation
                                row.fadeOut(400, function() { 
                                    row.remove(); 
                                });
                            } else {
                                Swal.fire({
                                    title: 'Failed!',
                                    text: res.message || "Cannot delete contact.",
                                    icon: 'error'
                                });
                                btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Error!',
                                text: "Failed to delete contact. Please try again.",
                                icon: 'error'
                            });
                            btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                        }
                    });
                }
            });
        });

        $(document).on('input change', '.contact-editable', function () {
            const row = $(this).closest('tr');
            const statusInput = row.find('.status').val('edit');  
        });

        function addContactPerson() {

            const index = $("#contactPersonTable tbody tr").length;
            const newRow = `
            <tr class="contactperson">
                <td>
                    <input type="hidden" name="contact[${index}][status]" value="add">

                    <input type="text" name="contact[${index}][name]" class="form-control">
                    <span class="error-text"></span>
                </td>

                <td>
                    <input type="email" name="contact[${index}][email]" class="form-control">
                    <span class="error-text"></span>
                </td>

                <td>
                    <input type="text" name="contact[${index}][mobile]" class="form-control">
                    <span class="error-text"></span>
                </td>

                <td>
                    <input type="text" name="contact[${index}][phone]" class="form-control">
                    <span class="error-text"></span>
                </td>

                <td>
                    <input type="text" name="contact[${index}][designation]" class="form-control">
                    <span class="error-text"></span>
                </td>

                <td>
                    <button type="button" class="btn btn-danger contact-delete-btn">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>`;

            $("#contactPersonTable tbody").append(newRow);
        }

        $(document).on("click", ".addContactPerson", function() {
            addContactPerson();
        });

    </script>

    <script>
        function toggleSameAsDirector() {
            const selectedDirector = $('#directorName').val();
            const emailId = $('#emailId').val();
            const mobileNumber = $('#mobileNumber').val();
            const $authName = $("input[name='contact[0][name]']");
            const $authEmail = $("input[name='contact[0][email]']");
            const $authMobile = $("input[name='contact[0][mobile]']");

            if ($('#sameAsDirector').is(':checked')) {
                if (!selectedDirector) {
                    toastr.warning("Please add Director Name first.");
                }
                if (!emailId) {
                    toastr.warning("Please add a Email first.");
                }
                if (!mobileNumber) {
                    toastr.warning("Please add a mobile Number first.");
                }
                
                if(!selectedDirector || !emailId || !mobileNumber){
                    $('#sameAsDirector').prop('checked', false);
                    return;
                }

                $authName.val(selectedDirector);
                $authEmail.val($('#emailId').val());
                $authMobile.val($('#mobileNumber').val());

            } else {
                $authName.val('');
                $authEmail.val('');
                $authMobile.val('');
            }
        }

        $(document).on('change', '#directorName', function () {
            const selectedDirector = $('#directorName').val()?.trim();

            if ($('#sameAsDirector').is(':checked') && selectedDirector) {
                toggleSameAsDirector();
            } else {
                $("input[name='contact[0][name]']");
                $("input[name='contact[0][email]']");
                $("input[name='contact[0][mobile]']");
            }
        });

        $('#sameAsDirector').on('change', toggleSameAsDirector);
            
    </script>
@endsection