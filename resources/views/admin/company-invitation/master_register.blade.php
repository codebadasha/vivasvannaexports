@extends('layouts.admin')
@section('title','All Invitations')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Invitations</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Invitations</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div id="masterLinkContainer" class="text-end mb-4">
                   @if(array_key_exists('invitation',$selectedAction) && in_array('master_create',$selectedAction['invitation']))
                    <button type="button" id="generateMasterLink" class="btn btn-primary"><i class="fa fa-plus pe-1"></i>Master link</button>
                    @if($masterLink)
                    <button type="button" id="copyMasterLink" data-link="{{ $masterLink }}" class="btn btn-success"><i class="fa fa-copy pe-1"></i>Master link</button>
                    @endif
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped table-bordered  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Email</th>
                                    <th>Register GSTN</th>
                                    <th>Invite Date</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($invitations))
                                @foreach($invitations as $ok => $ov)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ov->email }}</td>
                                    <td>{{ $ov->gstn ?? '---' }}</td>
                                    <td>{{ date('d/m/Y',strtotime($ov->created_at))  }}</td>
                                    <td>
                                        @if($ov->status == 1)
                                        <span class="badge bg-warning fs-5">Pending</span>
                                        @elseif($ov->status == 2)
                                        <span class="badge bg-success fs-5">Registered</span>
                                        @else
                                        <span class="badge bg-secondary fs-5">Expired</span>
                                        @endif
                                    </td>
                                    <td>{{ $ov->url }}</td>
                                    <td>
                                        @if($ov->status == 1)
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light me-1 copyInvitation" data-link="{{ $ov->url }}" title="Copy Invitation Link">
                                            <i class="fa fa-copy"></i>
                                        </button>
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

@endsection
@section('js')
@if(session('failed_csv'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Please wait...',
            text: 'File is downloading',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();

                setTimeout(() => {
                    let link = document.createElement('a');
                    link.href = "{{ route('admin.invitations.download', ['filename' => session('failed_csv')]) }}";
                    link.download = "{{ session('failed_csv') }}";
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    Swal.close();
                }, 500);
            }
        });
    });
</script>
@endif
<script type="text/javascript">
    $(document).on('click', '#generateMasterLink', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Master link generating',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('admin.invitations.createMasterInvitation') }}",
            type: "GET",
            success: function(response) {
                Swal.close(); // ✅ close loader

                if (response.status) {
                    let link = response.data.link;

                    if (!$("#copyMasterLink").length) {
                        $("#masterLinkContainer").append(
                            `<button type="button" id="copyMasterLink" class="btn btn-success" data-link="${link}"><i class="fa fa-copy pe-1"></i>Master link</button>`
                        );
                    } else {
                        $('#copyMasterLink').attr('data-link', link).prop('disabled', false);
                    }

                    toastr.success('Master link generated successfully!');
                } else {
                    toastr.error(response.message || 'Failed to generate master link');
                }
            },
            error: function(xhr) {
                Swal.close(); // ✅ close loader

                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong';
                toastr.error(errorMsg);
            }
        });
    });

   

    $(document).on('click', '.copyInvitation, #copyMasterLink', function() {
        const link = $(this).data('link');
        navigator.clipboard.writeText(link).then(() => {
            toastr.success('Invitation link copied to clipboard!');
        }).catch(() => {
            toastr.error('Failed to copy link.');
        });
    });

    $(document).on('click', '.resendInvitation', function() {
        const token = $(this).data('token');
        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        const url = `{{ route('admin.invitations.resend', ['token' => ':token']) }}`.replace(':token', token);
        $.ajax({
            url: url,
            method: "GET",
            success: function(res) {
                if (res.status) {
                    toastr.success(res.message || 'Invitation resent successfully.');
                } else {
                    toastr.error(res.message || 'Failed to resend invitation.');
                }
            },
            error: function() {
                toastr.error('Server error occurred while resending invitation.');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fa fa-envelope"></i>');
            }
        });
    });
</script>
@endsection