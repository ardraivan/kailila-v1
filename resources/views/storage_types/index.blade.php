@extends('layouts.app')

@section('title')
    Storage Types
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Storage Types</li>
@endsection

@section('content')
    <div class="card" style="margin: 0% 3%;">
        <div class="card-header">
            <div class="card-tools">
                @php
                    $userRole = Auth::check() ? Auth::user()->role->name : null;
                @endphp
                @if ($userRole === 'superadmin' || $userRole === 'admin')
                    <a href="{{ route('storage_types.create') }}" class="btn btn-sm btn-primary"
                        style="background-color: #C01E5E; border-color: #C01E5E;">Create</a>
                @endif

            </div>
            <div class="input-group input-group-sm" style="width: 300px;">
                <form id="search-form" action="{{ route('storage_types.index') }}" style="padding-top: 2%" method="GET">
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
            <div class="table-responsive" id="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 3%">#</th>
                            <th>
                                Name
                            </th>
                            <th>Description</th>
                            <th style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($storageTypes as $index => $storageType)
                            <tr>
                                <td>{{ ($storageTypes->currentPage() - 1) * $storageTypes->perPage() + $index + 1 }}</td>
                                <td>{{ $storageType->name }}</td>
                                <td>{{ $storageType->description }}</td>

                                @if ($userRole === 'superadmin' || $userRole === 'admin')
                                    @if ($storageType->deleted_at)
                                        <td>
                                            <form
                                                action="{{ route('storage_types.restore', ['storage_type' => $storageType->id]) }}"
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
                                                <a href="{{ route('storage_types.edit', ['storage_type' => $storageType->id]) }}"
                                                    class="btn btn-sm btn-primary rounded"
                                                    style="background-color: #1D98D9; border-color: #1D98D9;">Edit</a>
                                                <form
                                                    action="{{ route('storage_types.destroy', ['storage_type' => $storageType->id]) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this storage type?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-secondary ml-2 rounded">Delete</button>
                                                </form>
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
                {{ $storageTypes->links('pagination::bootstrap-4') }}
            </div>
            <div class="float-right">
                <a href="{{ route('storage_types.exportPDF', ['search' => $searchKeyword]) }}" class="btn btn-sm btn-info">
                    Export to PDF
                </a>
            </div>
        </div>
    </div>
@endsection
