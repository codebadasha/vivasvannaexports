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
        @if(Auth::guard('client')->user()->is_active == 0)
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Success Card --}}
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fa fa-ban text-danger" style="font-size:80px;"></i>
                        </div>

                        {{-- Heading --}}
                        <h2 class="fw-bold text-dark mb-3">Account Deactivated</h2>

                        {{-- Message --}}
                        <p class="text-muted mb-4">
                            Your company account with
                            <span class="fw-semibold text-primary">Vivasvanna Exports</span>
                            has been <span class="fw-semibold text-danger">deactivated</span>.<br>
                            Please contact our support team for assistance in reactivating your account.
                        </p>

                        {{-- Support Info --}}
                        <div class="mt-4">
                            <p class="mb-1">
                                <i class="fa fa-phone-alt text-primary me-2"></i>
                                Support: <a href="tel:+919876543210">+91 98765 43210</a>
                            </p>
                            <p class="mb-0">
                                <i class="fa fa-envelope text-primary me-2"></i>
                                Email: <a href="mailto:info@ratnamaniindustries.com">info@ratnamaniindustries.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Projects</p>
                                        <h4 class="mb-0"><a href="{{ route('client.project.index') }}?client={{ Auth::guard('client')->user()->id }}">{{ \App\Models\Project::where('client_id',Auth::guard('client')->user()->id)->where('is_active',1)->where('is_delete',0)->count() }}</a></h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-copy-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">Total PO Amount</p>
                                        <h4 class="mb-0"><a href="{{ route('client.po.index') }}?client={{ Auth::guard('client')->user()->id }}">{{ \App\Models\PurchaseOrder::where('client_id',Auth::guard('client')->user()->id)->where('is_active',1)->where('is_delete',0)->sum('subtotal') }}</a></h4>
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
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Invoice Raised</p>
                                        <h4 class="mb-0"><a href="{{ route('client.invoice.index') }}?client={{ Auth::guard('client')->user()->id }}">{{ \App\Models\PurchaseOrderInvoice::wherehas('po',function($q) { $q->where('client_id',Auth::guard('client')->user()->id); })->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</a></h4>
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
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Invoice Raised</p>
                                        <h4 class="mb-0"><a href="{{ route('client.invoice.index') }}?client={{ Auth::guard('client')->user()->id }}">{{ \App\Models\PurchaseOrderInvoice::where('mark_as_paid',1)->wherehas('po',function($q) { $q->where('client_id',Auth::guard('client')->user()->id); })->where('is_active',1)->where('is_delete',0)->count() }}</a></h4>
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
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Received Payment</p>
                                        <h4 class="mb-0"><a href="{{ route('client.invoice.index') }}?client={{ Auth::guard('client')->user()->id }}">{{ \App\Models\PurchaseOrderInvoice::where('mark_as_paid',1)->wherehas('po',function($q) { $q->where('client_id',Auth::guard('client')->user()->id); })->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</a></h4>
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
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Over Due Amount</p>
                                        <h4 class="mb-0"><a href="{{ route('client.invoice.index') }}?client={{ Auth::guard('client')->user()->id }}">{{ \App\Models\PurchaseOrderInvoice::whereDate('due_date','<',date('Y-m-d'))->where('mark_as_paid',0)->wherehas('po',function($q) { $q->where('client_id',Auth::guard('client')->user()->id); })->where('is_active',1)->where('is_delete',0)->sum('invoice_amount') }}</a></h4>
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
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
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
                                    <th>BOQ Qty</th>
                                    <th>PO Qty</th>
                                    <th>Delivered Qty</th>
                                    <th class='notexport'>Remaining Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($detail))
                                @foreach($detail as $ok => $ov)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ !is_null($ov->po) && !is_null($ov->po->project) ? $ov->po->project->name : '--' }}</td>
                                    <td>{{ !is_null($ov->po) ? $ov->po->po_number : '--' }}</td>
                                    <td>{{ !is_null($ov->varation) ? $ov->varation->product->product_type.' '.$ov->varation->grade : '--' }}</td>
                                    <td>{{ $ov->remaining_boq_qty }}</td>
                                    <td>{{ $ov->qty }}</td>
                                    <td>Coming Soon</td>
                                    <td>Coming Soon</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        @endif
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
                @if($kycDetails->cin_verify == 0)

                <p class="lead mb-4">
                    Now eligible for credit. Take advantage of your credit limit to grow your business.
                </p>
                @else

                <p class="lead mb-4">
                    Please complete your KYC to unlock your company’s credit facilities and access funding.
                </p>
                @endif

                @if($kycDetails->turnover != '0')
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <i class="fas fa-coins fa-3x text-warning me-3"></i>
                    <span class="display-4 fw-bold text-gradient-success">{{ $kycDetails->credit_amount }}</span>
                </div>
                @else
                <h3 class="lead mb-4">
                    {{ $kycDetails->credit_amount }}
                </h3>
                @endif
                <!-- CTA Button -->
                @if($kycDetails->cin_verify == 1)
                <a href="editCompanyProfile" class="btn btn-lg btn-primary px-5">
                    Apply For credit
                </a>
                @else
                <a href="editCompanyProfile" class="btn btn-lg btn-primary px-5">
                    Complete KYC
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
@if($kycDetails->is_terms_accepted == 0)
<script type="text/javascript">
    $(document).ready(function() {
        $('#termsAndCondition').modal({
            backdrop: 'static', // This disable for click outside event
            keyboard: true // This for keyboard event
        })
        $('#termsAndCondition').modal('show');
    })
</script>
@elseif($kycDetails->is_auto_password == 1)
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