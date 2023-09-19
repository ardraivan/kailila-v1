@extends('layouts.app')

@section('title')
    Rooms
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">My Rooms</li>
@endsection

@section('content')
    <div class="container">
        @if ($therapyRooms->isEmpty())
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 shadow">
                        <div class="card-body text-center">
                            <h2 style="font-weight: bold" class="text-danger mb-4">No Rooms Found</h2>
                            <p class="lead">You haven't created any therapy rooms yet.</p>
                            <a href="{{ route('storages.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus-circle mr-2"></i>Create Storage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($therapyRooms as $room)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        @php
                            // Mendapatkan nilai RGB dari hexcode
                            [$r, $g, $b] = sscanf($room->colour->hexcode, '#%02x%02x%02x');
                            // Menghitung tingkat kecerahan warna (0-255), semakin tinggi semakin terang
                            $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
                            // Jika tingkat kecerahan > 125, maka warna background terang, jika tidak maka gelap
                            $isLightBackground = $brightness > 125;
                        @endphp
                        <div class="card"
                            style="border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4); background-color: {{ $room->colour->hexcode }}">
                            <div class="card-body d-flex align-items-center pl-3 pr-2">
                                <div class="icon">
                                    <i
                                        class="ion ion-person-stalker text-{{ $isLightBackground ? 'black' : 'white' }} display-3"></i>
                                </div>
                                <div class="ml-3 d-flex flex-column">
                                    <h2 class="card-title text-{{ $isLightBackground ? 'black' : 'white' }} mb-2"
                                        style="font-size: 20px; font-weight: bold;">
                                        {{ $room->name }}
                                    </h2>
                                    <p class="card-text text-{{ $isLightBackground ? 'black' : 'white' }}"
                                        style="font-size: 12px;">
                                        <em>{{ $room->user->name }}</em>
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer bg-secondary text-right py-2"
                                style="border-radius: 0px 0px 10px 10px;">
                                <a href="{{ route('myrooms.show', $room) }}"
                                    class="btn btn-sm btn-success d-flex align-items-center justify-content-center"
                                    style="border-radius: 7px;">
                                    <span class="mr-1">Enter Room</span>
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
