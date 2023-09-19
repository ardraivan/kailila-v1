@extends('layouts.app')

@section('title')
    Edit Item Location
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a style="color: #C01A5B" href="{{ route('item_locations.index') }}">Item Locations</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Edit Item Location</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('item_locations.update', ['item_location' => $itemLocation->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="itemNameOption">Items Name</label>
                    <select id="itemNameOption" class="form-control" name="item_id" required>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}"
                                {{ $item->id == old('item_id', $itemLocation->item_id) ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <a style="color: #34333A; font-size: 14px" href="{{ route('items.create') }}">
                        <i style="color: #34333A" class="fas fa-plus-circle mr-1"></i> Add new item name
                    </a>
                </div>
                <div class="form-group">
                    <label for="storageNameOption">Storages Name</label>
                    <select id="storageNameOption" class="form-control" name="storage_id" required>
                        @foreach ($storages as $storage)
                            <option value="{{ $storage->id }}"
                                {{ $storage->id == old('storage_id', $itemLocation->storage_id) ? 'selected' : '' }}>
                                {{ $storage->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('storage_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <a style="color: #34333A; font-size: 14px" href="{{ route('storages.create') }}">
                        <i style="color: #34333A" class="fas fa-plus-circle mr-1"></i> Add new storage name
                    </a>
                </div>
                <div class="form-group">
                    <label for="quantityInput">Quantity</label>
                    <input type="number" id="quantityInput" class="form-control" min="1"
                        value="{{ old('quantity', $itemLocation->quantity) }}" name="quantity" required>
                    @error('quantity')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('item_locations.index') }}" class="btn btn-secondary"
                    style="background-color: #808080; margin-right: 1%;">Cancel</a>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #C01A5B; border-color: #C01A5B;">Update</button>
            </div>
        </form>
    </div>
@endsection
