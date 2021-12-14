@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Login info
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Username</th>
                        <th>IP Address</th>
                        <th>Device</th>
                        <th>Platform</th>
                        <th>Browser</th>
                        {{-- @if(Auth::user()->hasrole('System Administrator'))
                        <th class="text-center">Action</th>
                        @endif --}}
                    </tr>
                </thead>
                <tbody>						
                    @forelse ($loginInfos as $loginInfo)
                    <tr>
                        <td>{{ $loginInfo->status }}</td>
                        <td>{{ date('M d, Y h:i A', strtotime($loginInfo->created_at)) }}</td>
                        <td>{{ $loginInfo->email }}</td>
                        <td>{{ $loginInfo->ip_address }}</td>
                        <td>{{ $loginInfo->device }}</td>
                        <td>{{ $loginInfo->platform }}</td>
                        <td>{{ $loginInfo->browser }}</td>
                    </tr>
                    @empty
                    <tr>
                           <td class="text-danger text-center" colspan="10">*** Empty ***</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')

@endsection