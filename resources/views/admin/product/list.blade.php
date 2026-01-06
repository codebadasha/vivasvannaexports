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
                 <!-- <div class="text-end mb-4">
                    @if(array_key_exists('project',$selectedAction) && in_array('add',$selectedAction['project']))
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary"><i class="fa fa-plus pe-1"></i>Add</a>
                    @endif
                </div> -->
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>

                                    <td>Name</td>
                                    <td>Product Type</td>
                                    <td>Tax</td>
                                    <td>SKU</td>
                                    <td>Description</td>
                                    <td>Rate</td>
                                    <td>HSN/SAC</td>
                                    <td>Usage Unit</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($product))
                                @foreach($product as $ok => $ov)
                                <tr>

                                    <td>{{ $ov->name }}</td>
                                    <td>{{ $ov->product_type }}</td>
                                    <td class="text-left">
                                        <ul class="m-0 p-0">
                                            @foreach($ov->taxDetails as $Details)
                                            <ol class="p-0">{{ $Details-> tax_specification}} :- {{ $Details->tax_name_formatted }}</ol>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $ov->sku }}</td>
                                    <td>{{ $ov->description }}</td>
                                    <td>{{ $ov->rate }}</td>
                                    <td>{{ $ov->hsn_or_sac }}</td>
                                    <td>{{ $ov->unit }}</td>
                                    <!-- <td>
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
                                    </td> -->
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