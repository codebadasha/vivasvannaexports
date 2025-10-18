@extends('layouts.admin')
@section('title','Edit Policy')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Policy</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.policyList') }}">Policy List</a></li>
                            <li class="breadcrumb-item active">Edit Policy</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     
        <!-- end page title -->
        
        <!-- end row -->
        <form class="custom-validation" action="{{ route('admin.savePolicy') }}" method="post" id="editFaq" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $policy->id }}">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="color:red;float:right;" class="pull-right">* is mandatory</span>
                            </div>

                            <div class="mb-3">
                                <label>Name<span class="mandatory red">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" autocomplete="off" value="{{ $policy->title }}" readonly required/>
                            </div>

                            <div class="mb-3">
                                <label>Content<span class="mandatory red">*</span></label>
                                <textarea name="content" id="content" class="ckeditor">{{ $policy->content }}</textarea>
                                <span style="color: #f46a6a;" id="content_error"></span>
                            </div> 

                            <div class="button-items">
                                <center>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1" name="btn_submit" value="save">
                                        Update
                                    </button>
                                    <a href="{{ route('admin.policyList') }}" class="btn btn-danger waves-effect">
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