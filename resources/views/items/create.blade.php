@extends('layouts.app')

@section('title')
    Create Item
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a style="color: #C01A5B" href="{{ route('items.index') }}">Items</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Create Item</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="itemName">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="itemDescription">Item Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" placeholder="Enter Item Description" value="{{ old('description') }}" required>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="itemImagesFile">Image File</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('file_foto') is-invalid @enderror"
                                id="imageInput" name="file_foto" accept="image/jpeg, image/png, image/gif">
                            <label class="custom-file-label" for="imageInput">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-secondary btn-remove d-none" type="button">Remove</button>
                        </div>
                    </div>
                    @error('file_foto')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="itemCategoryOption">Item Category</label>
                    <select id="itemCategoryOption" class="form-control @error('item_category_id') is-invalid @enderror"
                        name="item_category_id" required>
                        @foreach ($itemCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('item_category_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <a style="color: #34333A; font-size: 14px" href="{{ route('item_categories.create') }}">
                        <i style="color: #34333A" class="fas fa-plus-circle mr-1"></i> Add new item category
                    </a>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('items.index') }}" class="btn btn-secondary"
                    style="background-color: #808080; margin-right: 1%;">Cancel</a>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #C01A5B; border-color: #C01A5B;">Submit</button>
            </div>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            // Mengubah label placeholder saat ada file yang dipilih
            $('#imageInput').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
                $('.btn-remove').removeClass('d-none');
            });

            // Menghapus data file saat tombol "Remove" diklik
            $('.btn-remove').on('click', function() {
                $('#imageInput').val('');
                $(this).addClass('d-none');
                $('.custom-file-label').html('Choose file');
            });
        });
    </script>
@endsection
