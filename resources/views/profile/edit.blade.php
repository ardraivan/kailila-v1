@extends('layouts.app')

@section('title')
    Edit Profile Superadmin
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Edit Profile (Superadmin)</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Edit Profile (Superadmin)</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('profile.update', ['user' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="userName">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="userName"
                        name="name" placeholder="Enter User Name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="userUsername">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="userUsername"
                        name="username" placeholder="Enter Username" value="{{ old('username', $user->username) }}" required>
                    @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="userPassword">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="userPassword" name="password" placeholder="Enter New Password (Leave empty to keep the current password)">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('home') }}" class="btn btn-secondary"
                    style="background-color: #808080; margin-right: 1%;">Cancel</a>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #C01A5B; border-color: #C01A5B;">Update Profile</button>
            </div>
        </form>
    </div>
@endsection
