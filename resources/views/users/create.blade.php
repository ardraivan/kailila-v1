@extends('layouts.app')

@section('title')
    Create User
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a style="color: #C01A5B" href="{{ route('users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Create User</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="userName">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="userName"
                        name="name" placeholder="Enter Name" required value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="userUsername">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="userUsername"
                        name="username" placeholder="Enter Username" required value="{{ old('username') }}">
                    @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="userPassword">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="userPassword" name="password" placeholder="Enter Password" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="userRoleOption">Role</label>
                    <select id="userRoleOption" class="form-control @error('role_id') is-invalid @enderror"
                        name="role_id" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('users.index') }}" class="btn btn-secondary"
                    style="background-color: #808080; margin-right: 1%;">Cancel</a>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #C01A5B; border-color: #C01A5B;">Submit</button>
            </div>
        </form>
    </div>
@endsection
