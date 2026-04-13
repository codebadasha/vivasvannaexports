@extends('layouts.admin')
@section('title','Edit Project')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Project</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.project.index') }}">Project List</a></li>
                            <li class="breadcrumb-item active">Edit Project</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <form class="custom-validation" action="{{ route('admin.project.update') }}" method="post" id="project" enctype="multipart/form-data">
            @csrf  
            <input type="hidden" name="id" value="{{ $detail->id }}">
            <div class="row">   
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="form-group mb-3">
                                <label>Select Client<span class="mandatory">*</span></label>
                                <input type="hidden" name="zoho_client_id" id="zoho_client_id" value="{{ old('zoho_client_id', $detail->zoho_client_id) }}">
                                <select class="form-control select2 @error('client_id') is-invalid @enderror" name="client_id" id="client_id" required>
                                    <option value="">Select Client</option>

                                    @foreach($clients as $sv)
                                        <option value="{{ $sv->id }}"
                                            data-id="{{ $sv->zoho_contact_id }}"
                                            {{ old('client_id', $detail->client_id) == $sv->id ? 'selected' : '' }}>
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
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $detail->name) }}" required>
                                 @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Select SalesOrders</label>
                                <select name="salesorders[]" id="salesorders" class="form-control select2" required multiple>
                                    <option value="">-- Select SalesOrder --</option>
                                    @foreach($so as $val)
                                    @continue($val->customer_id != $detail->zoho_client_id)
                                    <option value="{{ $val->id }}" {{ $val->project_id == $detail->id ? 'selected' : ''}}>{{ $val->salesorder_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Description </label>
                                <textarea name="description" class="form-control">{{ old('description', $detail->description) }}</textarea>
                            </div>

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Update
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
    const detail = @json($detail);
    console.log(detail)
</script>
<script type="text/javascript">
    $(document).ready(function() {
        
        
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
                    let selected = '';
                    if(so.project_id == detail.id){
                        selected = 'selected';
                    }
                    $('#salesorders').append(
                        `<option value="${so.id}" ${selected}>
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