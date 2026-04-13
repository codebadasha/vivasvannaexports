@extends('layouts.admin')
@section('title','Add Project')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Project</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.project.index') }}">Project List</a></li>
                            <li class="breadcrumb-item active">Add Project</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('admin.project.store') }}" method="post" id="project" enctype="multipart/form-data">
            @csrf  
            <div class="row">   
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Select Client<span class="mandatory">*</span></label>
                                <input type="hidden" name="zoho_client_id" id="zoho_client_id">
                                <select class="form-control select2 @error('client_id') is-invalid @enderror" name="client_id" id="client_id" required>
                                    <option value="">Select Client</option>

                                    @foreach($clients as $sv)
                                        <option value="{{ $sv->id }}"
                                            data-id="{{ $sv->zoho_contact_id }}"
                                            {{ old('client_id') == $sv->id ? 'selected' : '' }}>
                                            {{ $sv->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group mb-3">
                                <label>Name<span class="mandatory">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Select SalesOrders</label>
                                <select name="salesorders[]" id="salesorders" class="form-control select2" required disabled multiple>
                                    <option value="">-- Select SalesOrder --</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Description </label>
                                <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea>
                            </div>

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Save
                                    </button>
                                    <button type="submit" class="btn btn-secondary waves-effect waves-light mr-1" name="btn_submit" value="save_and_update">
                                        Save & Add New
                                    </button>
                                    <a href="{{ route('admin.project.index') }}" class="btn btn-danger waves-effect">
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
    const salesOrdersData = @json($so);
</script>
<script>
$(document).ready(function () {

    // Initially disable salesorder

    $(document).on('change', '#client_id', function () {

        $('#salesorders').prop('disabled', true);
        const selectedOption = $(this).find(':selected');
        const zohoClientId = selectedOption.data('id');
      
        const clientId = $(this).val();

        // Set hidden field
        $('#zoho_client_id').val(zohoClientId);

        // Enable salesorder dropdown
        $('#salesorders').prop('disabled', false);
        $('#salesorders').val('').trigger('change');
        // Clear existing options
        $('#salesorders').empty();

        // Add default option
        $('#salesorders').append('<option value="">-- Select SalesOrder --</option>');

        // Loop through JS salesOrdersData
        salesOrdersData.forEach(function (so) {

            // Match customer_id with zoho_client_id
            if (so.customer_id == zohoClientId) {

                $('#salesorders').append(
                    `<option value="${so.id}">
                        ${so.salesorder_number}
                    </option>`
                );
            }
        });

        // Refresh Select2
        
    });

});
</script>
@endsection