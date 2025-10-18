@extends('layouts.admin')
@section('title','Send Client Invitations')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Send Client Invitations</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">All Invitations</a></li>
                            <li class="breadcrumb-item active">Send Invitationy</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div> -->
        <form class="custom-validation" id="addClientCompany" action="{{ route('admin.invitations.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-9 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <div id="emailContainer">
                                <!-- Default two inputs (no remove buttons) -->
                                <div class="row emailRow">
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Email <span class="mandatory">*</span></label>
                                        <input type="email" name="emails[]" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="col-lg-9 m-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="button-items">
                            <center>
                                <button type="button" class="btn btn-primary addContactPerson" id="addRowBtn">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1"
                                    name="btn_submit" value="save">Send invitations</button>
                                <a href="{{ route('admin.invitations.index') }}" class="btn btn-danger waves-effect">Cancel</a>
                            </center>
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
        let i = 1;
        $('#addRowBtn').click(function() {
            // Create the new pair: input + remove button
            let newPair = `
            <div class="form-group col-md-5 mb-3">
                <label>Email <span class="mandatory">*</span></label>
                <input type="email" name="emails[]" class="form-control" required>
            </div>
            <div class="col-md-1 mt-4">
                <a href="javascript:void(0);" class="removeContactPerson btn btn-danger mt-1">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        `;

        $('#emailContainer .emailRow').append(newPair);

        });

        // Handle remove
        $(document).on('click', '.removeContactPerson', function() {
            i--;
            let btn = $(this).closest('.col-md-1');
            let input = btn.prev('.form-group');

            input.remove();
            btn.remove();


        });
    });
</script>
@endsection