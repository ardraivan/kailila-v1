@extends('layouts.app')

@section('title')
    Storages
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Storages</li>
@endsection

@section('content')
    <div class="card" style="margin: 0 3%;">
        <div class="card-header">
            <div class="card-tools">
                @php
                    $userRole = Auth::check() ? Auth::user()->role->name : null;
                @endphp
                @if ($userRole === 'superadmin' || $userRole === 'admin')
                    <a href="{{ route('storages.create') }}" class="btn btn-sm btn-primary"
                        style="background-color: #C01E5E; border-color: #C01E5E;">Create</a>
                @endif
            </div>
            <div class="input-group input-group-sm" style="width: 300px;">
                <form id="search-form" action="{{ route('storages.index') }}" style="padding-top: 2%" method="GET">
                    <input class="mb-2" type="text" id="search-input" name="search" class="form-control"
                        placeholder="Search..." value="{{ $searchKeyword ?? '' }}">
                    <!-- Input checkbox "include deleted" -->
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="include-deleted" name="include_deleted"
                            {{ session('include_deleted', false) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="include-deleted">
                            Include Deleted Data?
                        </label>
                    </div>
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
                            <th style="width: 20%">Storage Type</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($storages as $storage)
                            <tr>
                                <td>{{ $storages->firstItem() + $loop->index }}</td>
                                <td>{{ $storage->name }}</td>
                                <td>
                                    @if ($storage->storageType)
                                        {{ $storage->storageType->name }}
                                    @else
                                        <div class="d-flex align-items-center">
                                            <span style="color: #c01e5e; font-weight: bold">Data Unavailable, Related
                                                Storage Type Deleted</span>
                                        </div>
                                    @endif
                                </td>
                                @if ($userRole === 'superadmin' || $userRole === 'admin')
                                    @if ($storage->deleted_at)
                                        <td>
                                            <form action="{{ route('storages.restore', ['storage' => $storage->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm btn-success rounded">Restore</button>
                                            </form>
                                        </td>
                                    @else
                                        <td>
                                            <div class="btn-group">
                                                @if ($storage->storageType)
                                                    <a href="{{ route('storages.edit', ['storage' => $storage->id]) }}"
                                                        class="btn btn-sm btn-primary rounded"
                                                        style="background-color: #1D98D9; border-color: #1D98D9;">Edit</a>
                                                    <form
                                                        action="{{ route('storages.destroy', ['storage' => $storage->id]) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this storage?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-secondary ml-2 rounded">Delete</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-primary rounded"
                                                        style="background-color: #1D98D9; border-color: #1D98D9;" disabled
                                                        title="Action Unavailable">Edit</button>
                                                    <button class="btn btn-sm btn-secondary ml-2 rounded" disabled
                                                        title="Action Unavailable">Delete</button>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        <span class="text-muted" data-toggle="tooltip" data-placement="top"
                                            title="Only admin are allowed to manage this feature">
                                            <i class="fa fa-info-circle"></i>
                                            <span>Only admin are allowed.</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <div class="float-left">
                {{ $storages->links('pagination::bootstrap-4') }}
            </div>
            <div class="float-right">
                <a href="{{ route('storages.exportPDF', ['search' => $searchKeyword]) }}" class="btn btn-sm btn-info">
                    Export to PDF
                </a>
            </div>
        </div>
    </div>
@endsection
