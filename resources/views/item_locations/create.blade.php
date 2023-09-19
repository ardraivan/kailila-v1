@extends('layouts.app')

@section('title')
    Create Item Location
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a style="color: #C01A5B" href="{{ route('item_locations.index') }}">Item Locations</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Create Item Location</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('item_locations.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="itemNameOption">Items Name</label>
                    <select id="itemNameOption" class="form-control" name="item_id" required>
                        @if (isset($defaultItem))
                            <option value="{{ $defaultItem->id }}" selected>
                                {{ $defaultItem->name }}</option>
                        @else
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('item_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    @if (isset($defaultItem))
                        <span style="color: #34333A; font-size: 14px">
                            <i style="color: #34333A" class="fas fa-info-circle mr-1"></i>
                            Item name is set to "{{ $defaultItem->name }}".
                        </span>
                    @else
                        <a style="color: #34333A; font-size: 14px" href="{{ route('items.create') }}">
                            <i style="color: #34333A" class="fas fa-plus-circle mr-1"></i> Add new item name
                        </a>
                    @endif
                </div>
                <div class="form-group">
                    <label for="storageNameOption">Storages Name</label>
                    <select id="storageNameOption" class="form-control" name="storage_id" required>
                        @if (isset($defaultStorage))
                            <option value="{{ $defaultStorage->id }}" selected>
                                {{ $defaultStorage->name }}</option>
                        @else
                            @foreach ($storages as $storage)
                                <option value="{{ $storage->id }}"
                                    {{ old('storage_id') == $storage->id ? 'selected' : '' }}>
                                    {{ $storage->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('storage_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    @if (isset($defaultItem))
                        <span style="color: #34333A; font-size: 14px">
                            <i style="color: #34333A" class="fas fa-info-circle mr-1"></i>
                            Storage name is set to "{{ $defaultStorage->name }}".
                        </span>
                    @else
                        <a style="color: #34333A; font-size: 14px" href="{{ route('items.create') }}">
                            <i style="color: #34333A" class="fas fa-plus-circle mr-1"></i> Add new item name
                        </a>
                    @endif
                </div>
                <div class="form-group">
                    <label for="quantityInput">Quantity</label>
                    <input type="number" id="quantityInput" class="form-control" min="1"
                        value="{{ old('quantity', 1) }}" name="quantity" required>
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
                    style="background-color: #C01A5B; border-color: #C01A5B;">Submit</button>
            </div>
        </form>
    </div>
@endsection
