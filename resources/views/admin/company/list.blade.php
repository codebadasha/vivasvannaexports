@extends('layouts.admin')
@section('title','All Client Company')
@section('content')
@php
$turnover = [
"0" => "Below 50cr",
"1" => "50cr to 150cr",
"2" => "150cr to 250cr",
"3" => "250cr to 500cr",
"4" => "500cr to 1000cr",
"5" => "Above 1000cr",
];
@endphp
@php
    $showActionColumn = !empty(array_intersect(['view','edit','dashboard','setting','team','users'], $selectedAction['client-company']));
@endphp
 
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Client Company</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Client Company</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.client.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Client</label>
                                <select class="form-control select2" name="client">
                                    <option value="">Select Client</option>
                                    @forelse($allCilents as $sk => $sv)
                                    <option value="{{ $sv->id }}" {{ request()->client == $sv->id ? 'selected' : '' }}>{{ $sv->company_name }}</option>
                                    @empty
                                    <option value="">No Data Found</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">GSTIN Number</label>
                            <input class="form-control" name="gstin" value="{{ request()->gstin }}" placeholder="GSTIN Number">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">PAN Number</label>
                            <input class="form-control" name="pan" value="{{ request()->pan }}" placeholder="PAN Number">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="all" {{ request()->status == 'all' || !request()->has('status') ? 'selected' : '' }}>All</option>
                                <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Verify Status</label>
                            <select class="form-select" name="verify">
                                <option value="all" {{ request()->verify == 'all' || !request()->has('verify') ? 'selected' : '' }}>All</option>
                                <option value="1" {{ request()->verify == '1' ? 'selected' : '' }}>Verified</option>
                                <option value="0" {{ request()->verify == '0' ? 'selected' : '' }}>Unverified</option>
                            </select>
                        </div>

                        

                        <div class="col-md-3 mt-4">
                            <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>

                            {{-- Show reset button only if filter is applied --}}
                            @if($filter)
                            <a href="{{ route('admin.client.index') }}"
                                class="btn btn-danger mt-1 cancel_button">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="text-end mb-4">
                    @if(array_key_exists('client-company',$selectedAction) && in_array('add',$selectedAction['client-company']))
                    <a href="{{ route('admin.client.create') }}" class="btn btn-primary"><i class="fa fa-plus pe-1"></i>Add</a>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 35px;">Sr. No</th>
                                    <th>Company Name</th>
                                    <th>Director</th>
                                    <th>KYC Details</th>
                                    <th>MSME<br>Register</th>
                                    <th>Turnover</th>
                                    <th>Constitution fo Business</th>
                                    @if(array_key_exists('client-company',$selectedAction) && in_array('status',$selectedAction['client-company']))
                                    <th>active</th>
                                    @endif
                                    <th>Registered Address</th>
                                    @if($showActionColumn)
                                    <th class='notexport'>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($client))
                                @foreach($client as $ok => $ov)
                                <tr>

                                    <td>{{ $loop->iteration }}
                                        @if($ov->is_verify == 1)
                                            <i class="fa fa-check-circle text-success"></i>
                                        @else
                                            <i class="fa fa-times-circle text-danger"></i>
                                        @endif
                                    </td>
                                    <td>{{ $ov->company_name }} </td>
                                    <td>{{ $ov->director_name ?? '---' }}</td>
                                    <td id="cinTd_{{ $ov->id }}">GSTIN : {{ $ov->gstn   }}
                                        <br>
                                        PAN :{{ $ov->pan_number }}
                                        <br>
                                        CIN :
                                        @if (empty($ov->cin) && $ov->cin == 0 && !in_array($ov->gstDetails?->constitution_of_business ?? '', ['Proprietorship', 'Partnership']))
                                        <span class="badge bg-warning p-2" style="font-size: 12px;">CIN Pending</span>
                                        @elseif($ov->cin && $ov->cin_verify == 0 && !in_array($ov->gstDetails?->constitution_of_business ?? '', ['Proprietorship', 'Partnership'] ))
                                        <span class="badge bg-danger p-2" style="font-size: 12px;">({{ $ov->cin }})</span><br>
                                        <button class="btn btn-sm btn-outline-primary verifyCinBtn mt-1"
                                            data-id="{{ $ov->id }}" data-cin="{{ $ov->cin }}">
                                            Verify CIN
                                        </button>
                                        @else
                                        {{ $ov->cin }}
                                        @endif
                                    </td>
                                    <td>{{ $ov->msme_register == '1' ? "Yes" : "NO"}}</td>
                                    <td>{{ $turnover[$ov->turnover] }}</td>
                                    <td>{{ $ov->gstDetails->constitution_of_business }}</td>
                                    @if(array_key_exists('client-company',$selectedAction) && in_array('verify',$selectedAction['client-company']))
                                    <td>
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input class="form-check-input changeCompanyStatus" type="checkbox" id="customSwitch{{ $ok }}" value="1" data-id="{{ $ov->id }}" {{ $ov->is_active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="customSwitch{{ $ok }}"></label>
                                        </div>
                                    </td>
                                    @endif
                                    <td>{{ $ov->address }}</td>
                                    @if($showActionColumn)
                                    <td>
                                        @if(in_array('verify',$selectedAction['client-company'] ?? []) && $ov->is_verify == 0)
                                            <button class="btn btn-sm btn-outline-success verifyCompanyBtn"
                                                    data-id="{{ base64_encode($ov->id) }}"
                                                    data-admin-id="{{ $ov->admin_id ?? '' }}"
                                                    data-dashboard-url="{{ route('admin.client.clientDashboard',base64_encode($ov->id)) }}">
                                                <i class="fa fa-check-circle me-1"></i> Verify Company
                                            </button>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('users',$selectedAction['client-company']))
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-info authorizedPerson" data-id="{{ $ov->id }}">
                                            Users
                                        </a>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('edit',$selectedAction['client-company']))
                                        <a class="btn btn-sm btn-outline-primary waves-effect waves-light" href="{{ route('admin.client.edit',base64_encode($ov->id)) }}" role="button">
                                            Edit
                                        </a>
                                        @endif
                                        @if($ov->is_verify == 1)
                                            @if(array_key_exists('client-company',$selectedAction) && in_array('dashboard',$selectedAction['client-company']) )
                                            <a class="btn btn-sm btn-outline-success waves-effect waves-light dashboard" href="{{ route('admin.client.clientDashboard',base64_encode($ov->id)) }}" role="button" title="Dashboard" target="_blank" >
                                                Dashboard
                                            </a>
                                            @endif
                                            @if(array_key_exists('client-company',$selectedAction) && in_array('setting',$selectedAction['client-company']))
                                            <a class="btn btn-sm btn-outline-warning waves-effect waves-light overdueIntrestSetting settings" href="javascript:void(0);" role="button" title="Edit" data-id="{{ $ov->id }}">
                                                Settings
                                            </a>
                                            @endif
                                        @endif
                                        <!-- @if(array_key_exists('client-company',$selectedAction) && in_array('download',$selectedAction['client-company']))
                                        <a class="btn btn-secondary waves-effect waves-light" href="{{ route('admin.client.downloadCompanyDocumentZip',base64_encode($ov->id)) }}" role="button" title="Edit">
                                            Download
                                        </a> 
                                        @endif-->
                                        
                                        <!-- @if(array_key_exists('client-company',$selectedAction) && in_array('team',$selectedAction['client-company']))
                                        <a class="btn btn-dark waves-effect waves-light" href="{{ route('admin.client.assignTeamMember',base64_encode($ov->id)) }}" role="button" title="Edit">
                                            Team Member
                                        </a>
                                        @endif -->
                                        
                                        <!-- @if(array_key_exists('client-company',$selectedAction) && in_array('delete',$selectedAction['client-company']))
                                        <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.client.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this client company?');">
                                            Delete
                                        </a>
                                        @endif -->
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<div class="modal fade bd-example-modal-lg" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false"  role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
        </div>
    </div>
</div>
<div class="modal fade" id="overdueIntrestSetting" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Overdue Interest Settings</h4>
                <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modalBodyIntrest">

            </div>
        </div>
    </div>
</div>
<!-- Assign Admin & Verify Company Modal -->
<div class="modal fade" id="assignVerifyModal" tabindex="-1" aria-labelledby="assignVerifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignVerifyModalLabel">Assign Team member & Verify Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">This company is not assigned to any Team Member.</p>
                <div class="mb-3">
                    <label for="assign_admin_select" class="form-label">Select Admin</label>
                    <select id="assign_admin_select" class="form-select select2" style="width:100%;" required>
                        <option value="">-- Select Admin --</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btnConfirmAssignVerify">
                    <i class="fa fa-check me-1"></i> Assign & Verify
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    const canDashboard = @json(in_array('dashboard', $selectedAction['client-company'] ?? []));
    const canSetting   = @json(in_array('setting', $selectedAction['client-company'] ?? []));
</script>
<script type="text/javascript">
    
    $(document).on('click', '.authorizedPerson', function () {
        const id = $(this).data('id');
        $('.modal-content').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x"></i><br>Loading contacts...</div>');
        $('#myModal').modal({ backdrop: 'static', keyboard: false }).modal('show');
        
        $.ajax({
            url: "{{ route('admin.client.getContactPersons') }}",
            type: "POST",
            data: { id: id, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (html) {
                $('.modal-content').html(html);
                $('#myModal').modal({ backdrop: 'static', keyboard: false }).modal('show');
            }
        });
    });

    let originalRow = {};

    // ================== EDIT BUTTON ==================
    $(document).on('click', '.contact-edit-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');

        // Save original values
        originalRow[id] = {
            name: row.find('.name').text().trim(),
            email: row.find('.email').text().trim() === '-' ? '' : row.find('.email').text().trim(),
            mobile: row.find('.mobile').text().trim(),
            phone: row.find('.phone').text().trim() === '-' ? '' : row.find('.phone').text().trim(),
            designation: row.find('.designation').text().trim() === '-' ? '' : row.find('.designation').text().trim(),
            // isPrimary: row.find('.primary-col .badge').length > 0   // true if currently primary
        };

        // Convert cells to inputs
        row.find('.name').html(`<input type="text" class="form-control form-control-sm" value="${originalRow[id].name}">`);
        row.find('.email').html(`<input type="email" class="form-control form-control-sm" value="${originalRow[id].email}">`);
        row.find('.mobile').html(`<input type="text" class="form-control form-control-sm" value="${originalRow[id].mobile}">`);
        row.find('.phone').html(`<input type="text" class="form-control form-control-sm" value="${originalRow[id].phone}">`);
        row.find('.designation').html(`<input type="text" class="form-control form-control-sm" value="${originalRow[id].designation}">`);       

        // if (!originalRow[id].isPrimary) {
        //      row.find('.primary-col').html( `
        //         <div class="form-check">
        //             <input class="form-check-input set-primary-checkbox" type="checkbox" id="primaryCheck${id}">
        //             <label class="form-check-label" for="primaryCheck${id}">
        //                 Set as Primary Contact
        //             </label>
        //         </div>`);
        // }

        // Change action buttons
        row.find('.action-col').html(`
            <button class="btn btn-sm btn-success save-btn" data-id="${id}"><i class="fa fa-check"></i></button>
            <button class="btn btn-sm btn-secondary cancel-btn" data-id="${id}"><i class="fa fa-times"></i></button>
        `);
    });

    // ================== SAVE BUTTON ==================
    $(document).on('click', '.save-btn', function () {
        const btn = $(this);
        const row = btn.closest('tr');
        const id = btn.data('id');

        const name        = row.find('.name input').val().trim();
        const email       = row.find('.email input').val().trim();
        const mobile      = row.find('.mobile input').val().trim();
        const phone       = row.find('.phone input').val().trim();
        const designation = row.find('.designation input').val().trim();
        // const setAsPrimary = row.find('.set-primary-checkbox').is(':checked');
        const isPrimary = row.find('.primary-col .badge').length > 0;

        if (!name) {
            toastr.error("Name is required");
            return;
        }

        if (!mobile && !phone) {
            toastr.error("Either Mobile or Phone is required");
            return;
        }
        
        // // Email required if setting as primary
        // if (setAsPrimary && !email) {
        //     toastr.error("Email is required for Primary Contact");
        //     return;
        // }
        
        if (isPrimary && !email) {
            toastr.error("Email is required for Primary Contact");
            return;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('admin.client.updateContactPersons') }}",
            type: 'POST',
            data: {
                id: id,
                name: name,
                email: email,
                mobile: mobile,
                phone: phone,
                designation: designation,
                // is_primary: setAsPrimary ? 1 : 0,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message || "Contact updated successfully");

                    // Update row values
                    row.find('.name').text(name);
                    row.find('.email').text(email || '-');
                    row.find('.mobile').text(mobile || '-');
                    row.find('.phone').text(phone || '-');
                    row.find('.designation').text(designation || '-');

                    // Update Primary Column
                    // if (setAsPrimary) {
                    //     row.find('.primary-col').html('<span class="badge bg-success">Primary</span>');
                    // } else {
                    //     row.find('.primary-col').html(`
                    //         <button class="btn btn-sm btn-outline-success set-primary-contact-btn" data-id="${id}">
                    //             Set Primary
                    //         </button>
                    //     `);
                    // }

                    // Restore action buttons
                    row.find('.action-col').html(`
                        <button class="btn btn-sm btn-outline-primary contact-edit-btn"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-outline-danger contact-delete-btn"><i class="fa fa-trash"></i></button>
                    `);
                } else {
                    toastr.error(res.message || "Update failed");
                    btn.prop('disabled', false).html('<i class="fa fa-check"></i>');
                }
            },
            error: function () {
                toastr.error("Something went wrong.");
                btn.prop('disabled', false).html('<i class="fa fa-check"></i>');
            }
        });
    });

    // ================== CANCEL BUTTON ==================
    $(document).on('click', '.cancel-btn', function () {
        const row = $(this).closest('tr');
        const id = $(this).data('id');
        const orig = originalRow[id] || {};

        row.find('.name').text(orig.name || '');
        row.find('.email').text(orig.email || '-');
        row.find('.mobile').text(orig.mobile || '');
        row.find('.phone').text(orig.phone || '-');
        row.find('.designation').text(orig.designation || '-');

        // Restore Primary Column
        // if (orig.isPrimary) {
        //     row.find('.primary-col').html('<span class="badge bg-success">Primary</span>');
        // } else {
        //     row.find('.primary-col').html(`
        //         <button class="btn btn-sm btn-outline-success set-primary-contact-btn" data-id="${id}">
        //             Set Primary
        //         </button>
        //     `);
        // }

        // Restore action buttons
        row.find('.action-col').html(`
            <button class="btn btn-sm btn-outline-primary contact-edit-btn"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-outline-danger contact-delete-btn"><i class="fa fa-trash"></i></button>
        `);
    });

    // ================== DELETE BUTTON ==================
    $(document).on('click', '.contact-delete-btn', function () {
        const btn = $(this);
        const row = btn.closest('tr');
        const id = row.data('id');
        const isPrimary = row.find('.primary-col .badge').length > 0;

        if(isPrimary){
            toastr.error("Cannot delete Primary contact. Please set another contact as Primary first.");
            return;
        }
        // SweetAlert2 Confirmation
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
                            toastr.error(res.message || "Cannot delete contact");
                            
                            btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                        }
                    },
                    error: function () {
                        toastr.error(res.message || "Cannot delete contact");
                        btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                    }
                });
            }
        });
    });

    // ================== SET PRIMARY BUTTON ==================
    $(document).on('click', '.set-primary-contact-btn', function () {
        const btn = $(this);
        const row = btn.closest('tr');
        const id = btn.data('id');

        const email = row.find('.email').text().trim();

        // Check if email exists (ignore '-' or empty)
        if (!email || email === '-' || email === '') {
            toastr.error("Email is required to set this contact as Primary");
            return;
        }

        // Optional: Confirm before setting primary
        if (!confirm("Set this contact as Primary?")) {
            return;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('admin.client.setPrimaryContactPersons') }}",
            type: 'POST',
            data: { 
                id: id, 
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message || "Primary contact updated successfully");

                    // Update UI without reloading page
                    $('.primary-col').each(function() {
                        const currentRow = $(this).closest('tr');
                        const currentId = currentRow.data('id');

                        if (currentId == id) {
                            // This is now primary
                            $(this).html('<span class="badge bg-success">Primary</span>');
                        } else {
                            // Others get "Set Primary" button
                            $(this).html(`
                                <button class="btn btn-sm btn-outline-success set-primary-contact-btn" 
                                        data-id="${currentId}">
                                    Set Primary
                                </button>
                            `);
                        }
                    });
                } else {
                    toastr.error(res.message || "Failed to set as primary");
                    btn.prop('disabled', false).html('Set Primary');
                }
            },
            error: function () {
                toastr.error("Something went wrong. Please try again.");
                btn.prop('disabled', false).html('Set Primary');
            }
        });
    });
</script>
<script>

    $(document).on('click', '.overdueIntrestSetting', function() {
        $.ajax({
            url: "/admin/client-company/overdue-intrest-setting",
            type: "POST",
            data: {
                id: $(this).data('id')
            },
            success: function(data) {
                $('#overdueIntrestSetting').modal('show');
                $('#modalBodyIntrest').html(data);
                $('input.width').keyup(function() {
                    match = (/(\d{0,40})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
                    this.value = match[1] + match[2];
                });
                $("#taxSetting").validate({
                    errorElement: 'span',
                    rules: {
                        credit_amount: {
                            required: true,
                        },
                        interest_rate: {
                            required: true,
                        },
                        tolerance: {
                            required: true,
                        },
                    },
                    messages: {
                        credit_amount: {
                            required: "Please enter credit amount",
                        },
                        interest_rate: {
                            required: "Please enter interest rate",
                        },
                        tolerance: {
                            required: "Please enter tolerance",
                        },
                    }
                });
            }
        });
    })

    $(document).on('change', '.changeCompanyStatus', function() {
        var element = $(this);
        var option = this.checked ? 1 : 0;
        var id = element.data('id');

        $.ajax({
            url: "/admin/client-company/change-company-status",
            method: 'POST',
            data: {
                option: option,
                id: id
            },
            success: function(data) {
                if (data.status) {
                    toastr.success(data.message);
                } else {
                    element.prop('checked', false);
                    toastr.error(data.message);
                }
            }
        });
    });

    $(document).on('click', '.verifyCinBtn', function() {
        var element = $(this);
        var id = element.data('id');
        var cin = element.data('cin');

        $.ajax({
            url: "/admin/client-company/verify-cin",
            method: 'POST',
            data: {
                option: 1,
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                element.prop('disabled', true).text('Verifying...');
            },
            success: function(data) {
                if (data.status) {
                    toastr.success(data.message);

                    // 🔹 Replace entire <td> content with CIN number
                    $("#cinTd_" + id).html(cin);
                } else {
                    toastr.error(data.message);
                    element.prop('disabled', false).text('Verify CIN');
                }
            },
            error: function() {
                toastr.error("Something went wrong. Try again.");
                element.prop('disabled', false).text('Verify CIN');
            }
        });
    });

    $('#assignVerifyModal').on('shown.bs.modal', function () {
        $('#assign_admin_select').select2({
            dropdownParent: $('#assignVerifyModal'),
            placeholder: "Select Admin",
            allowClear: true
        });
    });

    $(document).on('click', '.verifyCompanyBtn', function() {
        const btn = $(this);
        const companyId = btn.data('id');
        const adminId   = btn.data('admin-id');
        const dashboardUrl   = btn.data('dashboard-url');

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');

        if (adminId && adminId != '') {
            // Already assigned → direct verify
            $.ajax({
                url: "{{ route('admin.client.verify-company') }}", // adjust route name
                method: 'POST',
                data: {
                    id: companyId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message || 'Company verified successfully');
                        const row = btn.closest('tr');
                        const actionTd = btn.closest('td');

                        // Change icon
                        row.find('td:first i')
                            .removeClass('fa-times-circle text-danger')
                            .addClass('fa-check-circle text-success');

                        const dashboardUrl = btn.data('dashboard-url');
                        btn.remove();
                        // Add Dashboard button
                        if (canDashboard) {
                            actionTd.append(
                                `<a class="btn btn-sm btn-outline-success waves-effect waves-light dashboard ms-1"
                                    href="${dashboardUrl}"
                                    target="_blank">
                                    Dashboard
                                </a>`
                            );
                        }

                        // Add Settings button
                        if (canSetting) {
                            actionTd.append(
                                `<a class="btn btn-sm btn-outline-warning waves-effect waves-light settings ms-1"
                                    href="javascript:void(0);"
                                    data-id="${atob(companyId)}">
                                    Settings
                                </a>`
                            );
                        }
                    } else {
                        toastr.error(response.message || 'Verification failed');
                    }
                },
                error: function() {
                    toastr.error('Failed to verify. Please try again.');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fa fa-check-circle me-1"></i> Verify Company');
                }
            });
        } else {
            // Not assigned → open modal
            $('#assignVerifyModal')
                .data('company-id', companyId)
                .modal('show');
            $('#assign_admin_select').val(null).trigger('change');

            btn.prop('disabled', false).html('<i class="fa fa-check-circle me-1"></i> Verify Company');
        }
    });

    // Handle modal "Assign & Verify" button
    $(document).on('click', '#btnConfirmAssignVerify', function() {
        const modal = $('#assignVerifyModal');
        const companyId = modal.data('company-id');
        const adminId   = $('#assign_admin_select').val();

        if (!adminId) {
            toastr.error('Please select an Team member');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');

        $.ajax({
            url: "{{ route('admin.client.assign-and-verify-company') }}", // adjust route name
            method: 'POST',
            data: {
                company_id: companyId,
                admin_id: adminId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message || 'Team member assigned & company verified');
                    modal.modal('hide');

                    // Remove button from table
                    const verifyCompanyBtn = $('.verifyCompanyBtn[data-id="' + companyId + '"]');
                    const row = verifyCompanyBtn.closest('tr');
                    const actionTd = verifyCompanyBtn.closest('td');

                    // Change icon
                    row.find('td:first i')
                        .removeClass('fa-times-circle text-danger')
                        .addClass('fa-check-circle text-success');

                    const dashboardUrl = verifyCompanyBtn.data('dashboard-url');

                    // Remove verify button
                    verifyCompanyBtn.remove();

                    // Add Dashboard button
                    if (canDashboard) {
                        actionTd.append(
                            `<a class="btn btn-sm btn-outline-success waves-effect waves-light dashboard ms-1"
                                href="${dashboardUrl}"
                                target="_blank">
                                Dashboard
                            </a>`
                        );
                    }

                    // Add Settings button
                    if (canSetting) {
                        actionTd.append(
                            `<a class="btn btn-sm btn-outline-warning waves-effect waves-light settings ms-1"
                                href="javascript:void(0);"
                                data-id="${atob(companyId)}">
                                Settings
                            </a>`
                        );
                    }
                    // Optional: show success badge
                    // $('.verifyCompanyBtn[data-id="' + companyId + '"]').closest('td').append('<span class="badge bg-success ms-2">Verified</span>');
                } else {
                    toastr.error(response.message || 'Operation failed');
                }
            },
            error: function() {
                toastr.error('Something went wrong');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa fa-check me-1"></i> Assign & Verify');
            }
        });
    });
</script>
@endsection