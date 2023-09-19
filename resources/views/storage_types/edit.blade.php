@extends('layouts.app')

@section('title')
    Edit Storage Type
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a style="color: #C01A5B" href="{{ route('storage_types.index') }}">Storage Types</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Edit Storage Type</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('storage_types.update', ['storage_type' => $storageType->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="storageTypeName">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="storageTypeName"
                        name="name" required value="{{ old('name', $storageType->name) }}"
                        placeholder="Enter Storage Type Name">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="storageTypeDesc">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                        id="storageTypeDesc" name="description" required
                        value="{{ old('description', $storageType->description) }}"
                        placeholder="Enter Storage Type Description">
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('storage_types.index') }}" class="btn btn-secondary"
                    style="background-color: #808080; margin-right: 1%;">Cancel</a>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #C01A5B; border-color: #C01A5B;">Update</button>
            </div>
        </form>
    </div>
@endsection
