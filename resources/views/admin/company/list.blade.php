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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 35px;">Sr. No</th>
                                    <th>Company Name</th>
                                    <th>Director</th>
                                    <th>GSTN</th>
                                    <th>PAN Number</th>
                                    <th>CIN Number</th>
                                    <th>MSME Register</th>
                                    <th>Turnover</th>
                                    @if(array_key_exists('client-company',$selectedAction) && in_array('verify',$selectedAction['client-company']))
                                    <th>active</th>
                                    @endif
                                    <th>Registered Address</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($client))
                                @foreach($client as $ok => $ov)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ov->company_name }}</td>
                                    <td>{{ $ov->director_name }}</td>
                                    <td>{{ $ov->gstn }}</td>
                                    <td>{{ $ov->pan_number }}</td>
                                    <td id="cinTd_{{ $ov->id }}">
                                        @if (empty($ov->cin))
                                        <span class="badge bg-warning fs-5">CIN Pending</span>
                                        @elseif($ov->cin && $ov->cin_verify == 0)
                                        <span class="badge bg-danger fs-5">({{ $ov->cin }})</span><br>
                                        <button class="btn btn-sm btn-outline-primary verifyCinBtn mt-1"
                                            data-id="{{ $ov->id }}" data-cin="{{ $ov->cin }}">
                                            Verify CIN
                                        </button>
                                        @else
                                        {{ $ov->cin }}
                                        @endif
                                    </td>
                                    <td>{{ $turnover[$ov->turnover] }}</td>
                                    <td>{{ $ov->msme_register == '1' ? "Yes" : "NO"}}</td>
                                    @if(array_key_exists('client-company',$selectedAction) && in_array('verify',$selectedAction['client-company']))
                                    <td>
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input class="form-check-input changeCompanyStatus" type="checkbox" id="customSwitch{{ $ok }}" value="1" data-id="{{ $ov->id }}" {{ $ov->is_active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="customSwitch{{ $ok }}"></label>
                                        </div>
                                    </td>
                                    @endif
                                    <td>{{ $ov->address }}</td>
                                    <td>
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('dashboard',$selectedAction['client-company']))
                                        <a class="btn btn-success waves-effect waves-light" href="{{ route('admin.client.clientDashboard',base64_encode($ov->id)) }}" role="button" title="Dashboard" target="_blank">
                                            Dashboard
                                        </a>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('download',$selectedAction['client-company']))
                                        <a class="btn btn-secondary waves-effect waves-light" href="{{ route('admin.client.downloadCompanyDocumentZip',base64_encode($ov->id)) }}" role="button" title="Edit">
                                            Download
                                        </a>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('setting',$selectedAction['client-company']))
                                        <a class="btn btn-warning waves-effect waves-light overdueIntrestSetting" href="javascript:void(0);" role="button" title="Edit" data-id="{{ $ov->id }}">
                                            Settings
                                        </a>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('team',$selectedAction['client-company']))
                                        <a class="btn btn-dark waves-effect waves-light" href="{{ route('admin.client.assignTeamMember',base64_encode($ov->id)) }}" role="button" title="Edit">
                                            Team Member
                                        </a>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('users',$selectedAction['client-company']))
                                        <a href="javascript:void(0);" class="btn btn-info authorizedPerson" data-id="{{ $ov->id }}">
                                            Users
                                        </a>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('edit',$selectedAction['client-company']))
                                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.client.edit',base64_encode($ov->id)) }}" role="button">
                                            Edit
                                        </a>
                                        @endif
                                        @if(array_key_exists('client-company',$selectedAction) && in_array('delete',$selectedAction['client-company']))
                                        <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.client.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this client company?');">
                                            Delete
                                        </a>
                                        @endif
                                    </td>
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
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Users</h4>
                <button type="button" class="close btn btn-secondary" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <p>Some text in the modal.</p>
            </div>
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
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click', '.authorizedPerson', function() {
        $.ajax({
            url: "/admin/client-company/get-company-authorized-person",
            type: "POST",
            data: {
                id: $(this).data('id')
            },
            success: function(data) {
                $('#myModal').modal('show');
                $('#modalBody').html(data);
            }
        });
    })

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
</script>
@endsection