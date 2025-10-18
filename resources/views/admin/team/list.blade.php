@extends('layouts.admin')
@section('title','All Team Member')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">All Team Member</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Team Member</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="text-end mb-4">
                    @if(array_key_exists('team',$selectedAction) && in_array('add',$selectedAction['team']))
                    <a href="{{ route('admin.team.create') }}" class="btn btn-primary"><i class="fa fa-plus pe-1"></i>Add</a>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.team.index') }}">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="all" {{ request()->status == 'all' || !request()->has('status') ? 'selected' : '' }}>All</option>
                                        <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ request()->status == '2' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Role <span class="mandatory">*</span></label>
                                    <select class="form-select select2" name="role_id" id="role_id">
                                        <option value="">Select Role</option>
                                        @forelse(\App\Models\Role::where('is_active',1)->where('is_delete',0)->get() as $rv)
                                        <option value="{{ $rv->id }}" {{ request()->role_id == $rv->id ? 'selected' : '' }}>
                                            {{ $rv->name }}
                                        </option>
                                        @empty
                                        <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary vendors save_button mt-1">Submit</button>

                                    {{-- Show reset button only if filter is applied --}}
                                    @if(request()->status != 'all' || request()->role_id != '')
                                    <a href="{{ route('admin.team.index') }}"
                                        class="btn btn-danger mt-1 cancel_button">Reset</a>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Full Name</th>
                                    <th>Role</th>
                                    <th>Mobile Number</th>
                                    <th>Email</th>
                                    <th>Default Member</th>
                                    @if(array_key_exists('team',$selectedAction) && in_array('status',$selectedAction['team']))
                                    <th>Status</th>
                                    @endif
                                    <th class='notexport'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($members))
                                @foreach($members as $mk => $mv)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mv->name }}</td>
                                    <td>{{ !is_null($mv->role) ? $mv->role->name : '--' }}</td>
                                    <td>{{ $mv->mobile }}</td>
                                    <td>{{ $mv->email }}</td>
                                    <td>
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input class="form-check-input setDefaultTeamMember"
                                                type="radio"
                                                name="default_team_member"
                                                id="defaultMember{{ $mk }}"
                                                value="{{ $mv->id }}"
                                                data-id="{{ $mv->id }}"
                                                {{ $mv->is_default == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    @if(array_key_exists('team',$selectedAction) && in_array('status',$selectedAction['team']))
                                    <td>
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input class="form-check-input teamMemberStatus" type="checkbox" id="customSwitch{{ $mk }}" value="1" data-id="{{ $mv->id }}" {{ $mv->is_active == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="customSwitch{{ $mk }}"></label>
                                        </div>
                                    </td>
                                    @endif

                                    <td>
                                        @if(array_key_exists('team',$selectedAction) && in_array('edit',$selectedAction['team']))
                                        <a class="btn btn-primary waves-effect waves-light" href="{{ route('admin.team.edit',base64_encode($mv->id)) }}" role="button" title="Edit">
                                            Edit
                                        </a>
                                        @endif
                                        @if(array_key_exists('team',$selectedAction) && in_array('delete',$selectedAction['team']))
                                        <a class="btn btn-danger waves-effect waves-light" href="{{ route('admin.team.delete',base64_encode($mv->id)) }}" role="button" onclick="return confirm('Do you want to delete this staff member?');" title="Delete">
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
            </div>
        </div>
    </div>
</div>

@endsection