@extends('layouts.app')

@section('title')
    Items
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Items</li>
@endsection

@section('content')
    <div class="card" style="margin: 0 3%;">
        <div class="card-header">
            <div class="card-tools">
                @php
                    $userRole = Auth::check() ? Auth::user()->role->name : null;
                @endphp
                @if ($userRole === 'superadmin' || $userRole === 'admin')
                    <a href="{{ route('items.create') }}" class="btn btn-sm btn-primary"
                        style="background-color: #C01E5E; border-color: #C01E5E;">Create</a>
                @endif

            </div>
            <div class="input-group input-group-sm" style="width: 300px;">
                <form id="search-form" action="{{ route('items.index') }}" style="padding-top: 2%" method="GET">
                    <input type="text" id="search-input" name="search" class="form-control mb-2" placeholder="Search..."
                        value="{{ $searchKeyword ?? '' }}">
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
                            <th>Description</th>
                            <th>Category</th>
                            <th style="width: {{ $userRole !== 'admin' && $userRole !== 'superadmin' ? '7%' : '22%' }}">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $items->firstItem() + $loop->index }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    @if ($item->category)
                                        {{ $item->category->name }}
                                    @else
                                        <div class="d-flex align-items-center">
                                            <span style="color: #c01e5e; font-weight: bold">Data Unavailable, Related
                                                Item Category Deleted</span>
                                        </div>
                                    @endif
                                </td>
                                @if ($item->deleted_at)
                                    <td>
                                        <form action="{{ route('items.restore', ['item' => $item->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success rounded">Restore</button>
                                        </form>
                                    </td>
                                @else
                                    <td>
                                        <div class="btn-group">
                                            @if ($item->file_foto)
                                                <a href="#" data-toggle="modal"
                                                    data-target="#lightbox{{ $item->id }}"
                                                    class="btn btn-sm btn-primary rounded show-btn"
                                                    style="background-color: #f79327 ; border-color:#f79327">Show</a>
                                            @else
                                                <button class="btn btn-sm btn-primary rounded show-btn"
                                                    style="background-color: #f79327; border-color:#f79327" disabled
                                                    title="Item doesn't have an image">Show</button>
                                            @endif
                                            @if ($userRole === 'superadmin' || $userRole === 'admin')
                                                @if ($item->category)
                                                    <a href="{{ route('items.edit', ['item' => $item->id]) }}"
                                                        class="btn btn-sm btn-primary rounded ml-1"
                                                        style="background-color: #1D98D9; border-color: #1D98D9;">Edit</a>
                                                    <form action="{{ route('items.destroy', ['item' => $item->id]) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-secondary ml-1 rounded">Delete</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-primary rounded ml-1"
                                                        style="background-color: #1D98D9; border-color: #1D98D9;" disabled
                                                        title="Action Unavailable">Edit</button>
                                                    <button class="btn btn-sm btn-secondary ml-1 rounded" disabled
                                                        title="Action Unavailable">Delete</button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="modal fade" id="lightbox{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="lightbox1Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <img src="{{ asset($item->file_foto) }}" alt="Image 1"
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
            <div class="float-right">
                <a href="{{ route('items.exportPDF', ['search' => $searchKeyword]) }}" class="btn btn-sm btn-info">
                    Export to PDF
                </a>
            </div>
        </div>
    </div>
@endsection
