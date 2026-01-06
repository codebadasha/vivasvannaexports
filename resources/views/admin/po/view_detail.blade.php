@extends('layouts.admin')
@section('title','View Purchase Order')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">View Purchase Order</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.po.index') }}">All POs</a></li>
                            <li class="breadcrumb-item active">View Purchase Order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>   
        <div>
            {!! $html !!}
        </div>
    </div>
</div>
@endsection
