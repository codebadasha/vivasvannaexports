@extends('layouts.admin')
@section('title','All Products')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Products</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Products</li>
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

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Product Type</th>
                                    <th>GST</th>
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!is_null($product))
                                @foreach($product as $ok => $ov)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ov->product_type }}</td>
                                        <td>{{ $ov->gst }}</td>
                                        <td>
                                            @if(array_key_exists('product',$selectedAction) && in_array('edit',$selectedAction['product']))
                                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.product.edit',base64_encode($ov->id)) }}" role="button">
                                                    Edit
                                                </a>
                                            @endif
                                            @if(array_key_exists('product',$selectedAction) && in_array('delete',$selectedAction['product']))
                                                <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.product.delete',base64_encode($ov->id)) }}" role="button" onclick="return confirm('Do you want to delete this product?');">
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
@endsection