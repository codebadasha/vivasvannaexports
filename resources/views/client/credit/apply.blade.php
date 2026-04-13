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
                            <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Credit Request List</a></li>
                            <li class="breadcrumb-item active">Apply For Credit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        
        <div class="row">   
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="progress" style="background: #f9f8f8b3; border: 1px groove #a3a3a3; height: 20px !important; border-radius: 12px;">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width:0%; font-size: 13px;">Step 1 of 3</div>
                    </div>

                    <!-- Step 1: Bank -->
                    <div id="step1" class="card mb-4">
                        <div class="card-body">
                            <div class="alert alert-info statement-alert" style="display:none;">
                                    Please upload your last <strong>6 months bank statement (PDF)</strong>.<br>  
                                    If your PDF is password protected, enter the password before uploading.
                                </div>
                            <h5>Step 1: Bank Statement (Last 6 Months)</h5>

                            <form id="bankInitForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>Credit Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="credit_amount" class="form-control" required min="10000">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Bank <span class="text-danger">*</span></label>
                                        <select name="bank_id" class="form-control select2" required>
                                            <option value="">Select Bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->perfios_institution_id }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Proceed to Upload</button>
                            </form>

                            <div id="bankUploadSection" style="display:none;" class="mt-4">
                                
                                <form id="bankUploadForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="credit_request_id" id="credit_request_id">
                                    <input type="hidden" name="perfios_transaction_id" id="perfios_transaction_id">

                                    <div class="mb-3">
                                        <label>PDF File <span class="text-danger">*</span></label>
                                        <input type="file" name="statement" accept=".pdf" class="form-control" id="statementFile" required>
                                    </div>

                                    <div class="mb-3" id="passwordGroup" >
                                        <label>PDF Password <span class="text-danger">*</span></label>
                                        <input type="text" name="password" class="form-control" id="pdfPassword">
                                    </div>
                                    <button type="submit" class="btn btn-success" id="uploadBtn" disabled>Upload & Analyze</button>
                                </form>
                                <div id="bankStatus" class="mt-3"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: GST -->
                    <div id="step2" class="card mb-4" style="display:none;">
                        <div class="card-body">
                            <h5>Step 2: GST Score</h5>
                            <form id="gstInitForm">
                                @csrf
                                <input type="hidden" name="credit_request_id" id="gst_credit_request_id">
                                <div class="mb-3">
                                    <label>GST Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Generate OTP</button>
                            </form>

                            <div id="otpSection" style="display:none;" class="mt-4">
                                <label>Enter OTP</label>
                                <input type="text" id="otp" class="form-control" maxlength="6">
                                <button id="submitOtpBtn" class="btn btn-success mt-2">Submit OTP</button>
                            </div>
                            <div id="gstStatus" class="mt-3"></div>
                        </div>
                    </div>

                    <!-- Step 3: Balance -->
                    <div id="step3" class="card mb-4" style="display:none;">
                        <div class="card-body">
                            <h5>Step 3: Balance Sheets (Last 3 Years)</h5>
                            <form action="{{ route('client.credit.balance.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="credit_request_id" id="balance_credit_request_id">

                                @for($i = 1; $i <= 3; $i++)
                                    @php $y = date('Y') - $i; @endphp
                                    <div class="mb-3">
                                        <label>FY {{ $y-1 }}-{{ $y }} <span class="text-danger">*</span></label>
                                        <input type="file" name="balance_sheets[{{ $y }}]" accept=".pdf" class="form-control" required>
                                    </div>
                                @endfor

                                <button type="submit" class="btn btn-success mt-3">Submit Application</button>
                            </form>
                        </div>
                        </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')

<script>
    // Set local worker path
   
    // Toastr config
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": 5000
    };

    let currentStep = 1;
    const pending = @json($pending ?? null);

    function showStep(step) {
        $('[id^="step"]').hide();
        $('#step' + step).show();
        $('#progressBar').css('width', (step / 3 * 100) + '%').text(`Step ${step} of 3`);
    }

    if (pending) {
        currentStep = (pending.request_step != 'draft' ? ((pending.request_step == 'gst_report_fetched')? 3 : 2) : 1);
        showStep(currentStep);
        if (currentStep === 2) $('#gst_credit_request_id').val(pending.id);
        if (currentStep === 3) $('#balance_credit_request_id').val(pending.id);
    } else {
        showStep(1);
    }

    // ── Bank Init ────────────────────────────────────────
    $('#bankInitForm').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Preparing secure bank upload....',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '{{ route("client.credit.bank.init") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) {
                    $('#credit_request_id').val(res.credit_request_id);
                    $('#perfios_transaction_id').val(res.perfiosTransactionId);
                    $('#bankInitForm').hide();
                    $('#bankUploadSection').show();
                    $('.statement-alert').show();
                    toastr.success('Bank connected successfully. Please upload your last 6 months bank statement.');
                } else {
                    toastr.error('We could not prepare the bank upload process. Please try again.');
                }
            },
            error: function() {
                Swal.close();
                toastr.error('Connection problem. Please try again');
            }
        });
    });

    // ── PDF Password Detection ───────────────────────────
    $('#statementFile').on('change', function() {
        let file = this.files[0];
        if (!file || file.type !== 'application/pdf') {
            toastr.error('Only PDF allowed');
            this.value = '';
            $('#uploadBtn').prop('disabled', true);
            $('#passwordGroup').hide();
            return;
        }

        $('#uploadBtn').prop('disabled', false);
       
    });

    // ── Bank Upload ──────────────────────────────────────
    $('#bankUploadForm').submit(function(e) {
        e.preventDefault();

        if ($('#pdfPassword').prop('required') && !$('#pdfPassword').val()) {
            toastr.warning('Password required for protected PDF');
            return;
        }

        Swal.fire({
            title: 'Uploading & Analyzing...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("client.credit.bank.upload") }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                Swal.close();
                if (res.success) {
                    toastr.success(res.message);
                    $('#gst_credit_request_id').val($('#credit_request_id').val());
                    currentStep = 2;
                    showStep(2);
                } else {
                    toastr.error(res.message || 'Upload failed');
                }
            },
            error: function() {
                Swal.close();
                toastr.error('Connection problem. Please try again');
            }
        });
    });

    // ── GST Init ─────────────────────────────────────────
    $('#gstInitForm').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Requesting OTP...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '{{ route("client.credit.gst.init") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.close();
                if (res.success) {
                    toastr.success('OTP sent to registered mobile');
                    $('#otpSection').show();
                } else {
                    toastr.error(res.message || 'Failed to send OTP');
                }
            },
            error: function() {
                Swal.close();
                toastr.error('Network error');
            }
        });
    });

    // ── GST Submit OTP ───────────────────────────────────
    $('#submitOtpBtn').click(function() {
        let otp = $('#otp').val().trim();
        if (otp.length !== 6) {
            toastr.warning('Enter valid 6-digit OTP');
            return;
        }

        Swal.fire({
            title: 'Verifying OTP...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '{{ route("client.credit.gst.submit") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                otp: otp,
                credit_request_id: $('#gst_credit_request_id').val()
            },
            success: function(res) {
                Swal.close();
                if (res.success) {
                    toastr.success('GST verified successfully');
                    currentStep = 3;
                    showStep(3);
                    $('#balance_credit_request_id').val($('#gst_credit_request_id').val());
                } else {
                    toastr.error(res.message || 'Invalid OTP');
                }
            },
            error: function() {
                Swal.close();
                toastr.error('Network error');
            }
        });
    });
</script>
@endsection
