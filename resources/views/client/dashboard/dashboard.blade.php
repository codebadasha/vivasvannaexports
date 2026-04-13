@extends('layouts.client')
@section('title','Dashboard')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid" style="height: -webkit-fill-available;">
                            <a href="{{ route('client.project.index') }}">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Projects</p>
                                            <h4 class="mb-0">{{ $data['total_projects']}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('client.po.index') }}">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Purchase Orders</p>
                                            <h4 class="mb-0">{{ $data['total_po_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['total_po_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-archive-in font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('client.invoice.index') }}">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Invoices Raised</p>
                                            <h4 class="mb-0">{{ $data['total_invoice_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['total_invoice_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('client.invoice.index', ['status' => 1]) }}">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Paid Invoices</p>
                                            <h4 class="mb-0">{{ $data['paid_invoice_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['paid_invoice_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('client.invoice.index', ['status' => 3]) }}">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Overdue Invoices</p>
                                            <h4 class="mb-0">{{ $data['overdue_invoice_count'] }}</h4>
                                            <h5 class="mb-0">₹ {{ number_format($data['overdue_invoice_amount'], 2, '.', ',') }}</h5>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid" style="height: -webkit-fill-available;">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Interest on Over Dues</p>
                                        <h4 class="mb-0">Coming Soon</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Project</th>
                                    <th>PO Number</th>
                                    <th>Item</th>
                                    <th>PO Qty</th>
                                    <th>Delivered Qty</th>
                                    <th>Remaining Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                               @if($items->isNotEmpty())
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->salesOrder?->project?->name ?? '---' }}
                                        </td>
                                        <td>
                                            {{ $item->salesOrder?->salesorder_number ?? '--' }}
                                        </td>
                                        <td>
                                            {{ $item->name ?? '---' }}
                                        </td>
                                        <td>
                                            {{ intval($item->quantity) }} {{ $item->unit ?? '' }}
                                        </td>
                                        <td>
                                            {{ number_format($item->delivered_quantity, 2) }} {{ $item->unit ?? '' }}
                                        </td>
                                        <td>
                                            @php
                                                $delivered = $item->delivered_quantity;
                                                $remaining = max(0, $item->quantity - $delivered);
                                            @endphp
                                            {{ number_format($remaining, 2) }} {{ $item->unit ?? '' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No records found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade creditModal" id="creditModal{{ $kycDetails->id }}" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-grey" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center pt-0 pb-4 mb-3">
                <h2 class="fw-bold mb-2 text-success">Your Credit Options Await</h2>
                @if((empty($kycDetails->cin) || $kycDetails->cin_verify == 0) && in_array($kycDetails->gstDetails->constitution_of_business, ['Proprietorship', 'Partnership']))

                <p class="lead mb-4">
                    Please complete your KYC to unlock your company’s credit facilities and access funding.
                </p>
                @else
                <p class="lead mb-4">
                    Now eligible for credit. Take advantage of your credit limit to grow your business.
                </p>

                @endif

                <!-- @if($kycDetails->turnover == '0') -->
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <!-- <i class="fas fa-coins fa-3x text-warning me-3"></i> -->
                    <span class="display-6 fw-bold text-gradient-success">Unlock Your limit</span>
                </div>
                <!-- @else
                <h3 class="lead mb-4">
                    ₹ {{ $kycDetails->credit_amount }}
                </h3>
                @endif -->
                <!-- CTA Button -->
                @if((empty($kycDetails->cin) || $kycDetails->cin_verify == 0) && !in_array($kycDetails->gstDetails->constitution_of_business, ['Proprietorship', 'Partnership']))
                <a href="{{ route('client.editCompanyProfile') }}" class="btn btn-lg btn-primary px-5">
                    Complete KYC
                </a>
                @else
                <a href="{{ route('client.credit.apply') }}" class="btn btn-lg btn-primary px-5">
                    Apply For credit
                </a>
                @endif
                <!-- Optional Decline -->
                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">No Thanks</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePassword" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <form class="custom-validation" action="{{ route('client.updatePassword') }}" method="post" id="changePassword">
                <div class="modal-header">
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div>
                            Your password was system-generated for security. Please change it to a new secure password.
                        </div>
                    </div>
                    @csrf
                    <div class="form-group mb-3">
                        <label>Current Password<span class="mandatory">*</span></label>
                        <input type="password" class="form-control" name="old_password" required placeholder="Current Password" />
                    </div>

                    <div class="form-group mb-3">
                        <label>New Password<span class="mandatory">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="New Password" id="inputNewPassword" />
                            <span class="input-group-text toggle-password" style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Confirm New Password<span class="mandatory">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm New Password" />
                            <span class="input-group-text toggle-password" style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: center!important;">
                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Change Password</button>
                    <a href="{{ route('client.logout') }}" class="btn btn-danger">Decline</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="termsAndCondition" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Terms & Conditions</h4>
            </div>
            <div class="modal-body">
                @php $content = \App\Models\PolicyContent::where('key','TERMS')->first(); @endphp
                {!! $content->content !!}
            </div>
            <div class="modal-footer" style="justify-content: center!important;">
                <button id="accept" class="btn btn-primary">Accept</button>
                <a href="{{ route('client.logout') }}" class="btn btn-danger">Decline</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@if($kycDetails->is_terms_accepted == 0 && $kycDetails->is_verify == 1 && $kycDetails->is_active == 1)
<script type="text/javascript">
    $(document).ready(function() {
        $('#termsAndCondition').modal({
            backdrop: 'static', // This disable for click outside event
            keyboard: true // This for keyboard event
        })
        $('#termsAndCondition').modal('show');
    })
</script>
@elseif($kycDetails->is_auto_password == 1 && $kycDetails->is_verify == 1 && $kycDetails->is_active == 1)
<script type="text/javascript">
    $(document).ready(function() {
        $('#changePassword').modal({
            backdrop: 'static', // This disable for click outside event
            keyboard: true // This for keyboard event
        })
        $('#changePassword').modal('show');
    })
</script>
@else
<script type="text/javascript">
    $(document).ready(function() {

        const today = new Date().toISOString().slice(0, 10); // e.g., "2025-08-31"
        const id = $('.creditModal').attr("id");
        const lastShown = localStorage.getItem(`creditModal_lastShown_${id}`);

        if (lastShown !== today) {
            $('.creditModal').modal({
                backdrop: 'static',
                keyboard: true
            });
           $('.creditModal').modal('show');
            localStorage.setItem(`creditModal_lastShown_${id}`, today);
        }
    });
</script>
@endif

<script type="text/javascript">
    $(document).on('click', '#accept', function() {
        $.ajax({
            type: 'get',
            url: '/client/accept-terms',
            success: function(data) {
                $('#termsAndCondition').modal('hide');
                location.reload();
            }
        })
    })
</script>
<script>
    $(document).ready(function() {
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
@endsection