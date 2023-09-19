@extends('layouts.app')

@section('title')
    Edit Storage
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a style="color: #C01A5B" href="{{ route('storages.index') }}">Storages</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card card-primary" style="margin: 0 3%;">
        <div class="card-header" style="background-color: #C01A5B;">
            <h3 class="card-title">Edit Storage</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('storages.update', ['storage' => $storage->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="storageTypeName">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="storageTypeName"
                        name="name" placeholder="Enter Storage Type Name" value="{{ old('name', $storage->name) }}"
                        required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="storageTypeOption">Storage Type</label>
                    <select id="storageTypeOption" class="form-control @error('storage_type_id') is-invalid @enderror"
                        name="storage_type_id" required>
                        @foreach ($storageTypes as $storageType)
                            <option value="{{ $storageType->id }}"
                                {{ $storageType->id == old('storage_type_id', $storage->storage_type_id) ? 'selected' : '' }}>
                                {{ $storageType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('storage_type_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div id="colourAndUserOptions">
                    @if ($storageTypes->where('name', 'Therapy Room')->count() > 0)
                        <div class="form-group">
                            <label for="colourOption">Choose Room Colour (for Therapy Room)</label>
                            <select id="colourOption" class="form-control @error('colour_id') is-invalid @enderror"
                                name="colour_id">
                                <option style="background-color: white !important; font-weight: normal !important"
                                    value="" disabled>-- Choose a colour --</option>
                                @foreach ($colours as $colour)
                                    @php
                                        $selectedColour = $colour->hexcode;
                                        $isDarkColor = in_array($selectedColour, ['#0000FF', '#FF0000', '#800080', '#808080']);
                                        $textColor = $isDarkColor ? 'white' : 'black';
                                    @endphp
                                    <option value="{{ $colour->id }}"
                                        style="background-color: {{ $selectedColour }}; color: {{ $textColor }};"
                                        {{ $colour->id == old('colour_id', $storage->colour_id) ? 'selected' : '' }}>
                                        {{ $colour->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('colour_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="userOption">Choose User (for Therapy Room)</label>
                            <select id="userOption" class="form-control @error('user_id') is-invalid @enderror"
                                name="user_id">
                                <option value="" disabled selected>-- Choose a user --</option>
                                @foreach ($users as $user)
                                    @if ($user->role->name !== 'admin')
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == old('user_id', $storage->user_id) ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('storages.index') }}" class="btn btn-secondary"
                    style="background-color: #808080; margin-right: 1%;">Cancel</a>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #C01A5B; border-color: #C01A5B;">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // Show/hide colour and user options based on selected storage type
        const storageTypeOption = document.getElementById('storageTypeOption');
        const colourAndUserOptions = document.getElementById('colourAndUserOptions');
        const colourOption = document.getElementById('colourOption');

        function toggleColourAndUserOptions() {
            const isTherapyRoom = storageTypeOption.options[storageTypeOption.selectedIndex].text === 'Therapy Room';
            colourAndUserOptions.style.display = isTherapyRoom ? 'block' : 'none';
        }

        // Call the function on page load (to handle any initial values if editing existing data)
        toggleColourAndUserOptions();

        // Add event listener to the storage type select element
        storageTypeOption.addEventListener('change', toggleColourAndUserOptions);

        // Add event listener to the colour select element
        colourOption.addEventListener('change', function() {
            const selectedColour = colourOption.options[colourOption.selectedIndex].style.backgroundColor;
            colourOption.style.backgroundColor = selectedColour;

            // Set text color to white if background is dark (blue, red, purple, gray), otherwise black
            if (selectedColour === 'rgb(0, 0, 255)' || selectedColour === 'rgb(255, 0, 0)' || selectedColour ===
                'rgb(128, 0, 128)' || selectedColour === 'rgb(128, 128, 128)') {
                colourOption.style.color = 'white';
            } else {
                colourOption.style.color = 'black';
            }
            colourOption.style.fontWeight = 'bold';
        });
    </script>

    <style>
        /* CSS untuk teks yang bold */
        #colourOption option {
            font-weight: bold;
        }

        /* CSS untuk teks yang putih jika latar belakangnya berwarna biru, merah, ungu, atau abu-abu */
        #colourOption option[style*="background-color: #0000FF"],
        #colourOption option[style*="background-color: #FF0000"],
        #colourOption option[style*="background-color: #800080"],
        #colourOption option[style*="background-color: #808080"] {
            color: white;
        }
    </style>
@endsection
