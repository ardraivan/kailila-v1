@extends('layouts.app')

@section('title')
    Users
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
    <div class="card" style="margin: 0 3%;">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary"
                    style="background-color: #C01E5E; border-color: #C01E5E;">Create</a>
            </div>
            <div class="input-group input-group-sm" style="width: 300px;">
                <form id="search-form" action="{{ route('users.index') }}" method="GET">
                    <input type="text" id="search-input" name="search" class="form-control" placeholder="Search..."
                        value="{{ isset($searchKeyword) ? $searchKeyword : '' }}">
                </form>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 3%">#</th>
                            <th>
                                Name
                            </th>
                            <th style="width: 20%">Username</th>
                            <th style="width: 20%">Role</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    @if ($user->role->name === 'superadmin')
                                        <span class="text-muted" data-toggle="tooltip" data-placement="top"
                                            title="Superadmin (No Actions)">
                                            <i class="fa fa-info-circle"></i>
                                            <span>Superadmin</span>
                                        </span>
                                    @else
                                        <div class="btn-group">
                                            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                                class="btn btn-sm btn-primary rounded">Edit</a>
                                            <form action="{{ route('users.destroy', ['user' => $user->id]) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-secondary ml-2 rounded">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
