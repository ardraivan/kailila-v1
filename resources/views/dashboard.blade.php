@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @php
                    $currentTime = \Carbon\Carbon::now('Asia/Jakarta');
                    $hour = $currentTime->hour;
                    
                    if ($hour >= 0 && $hour < 5) {
                        $greeting = 'Good Night';
                    } elseif ($hour >= 5 && $hour < 10) {
                        $greeting = 'Good Morning';
                    } elseif ($hour >= 10 && $hour < 17) {
                        $greeting = 'Good Afternoon';
                    } elseif ($hour >= 17 && $hour < 20) {
                        $greeting = 'Good Evening';
                    } else {
                        $greeting = 'Good Night';
                    }
                    
                    $userName = auth()->check() ? auth()->user()->name : 'Guest';
                @endphp

                <div id="imageDiv" class="p-3 mb-2 rounded-lg"
                    style="background-image: url('{{ asset('images/home-banner-edit.jpg') }}'); background-size: cover; display: flex; align-items: center; justify-content: center; flex-direction: column; height: 300px;">
                    <h3 class="text-center text-white"
                        style="font-size: 45px; line-height: 45px; padding: 0; color: #f2f2f2 !important">
                        {{ $greeting }},
                        <strong>{{ $userName }}</strong>!
                    </h3>
                    <h4 class=" mt-4 text-center text-white"
                        style="font-size: 35px; line-height: 30px; padding: 0; color: #f2f2f2 !important">
                        It's great to see you!
                    </h4>
                </div>

            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner" style="background-color: #809FB3; border-color: #809FB3;">
                        <h3>{{ $itemCount }}</h3>
                        <p>Items</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('items.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner" style="background-color: #9BD0B6; border-color: #9BD0B6;">
                        <h3>0</h3>
                        <p>Therapist</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('coming_soon') }}" class="small-box-footer">Coming soon <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner" style="background-color: #D68D96; border-color: #D68D96;">
                        <h3 style="color: white">0</h3>
                        <p style="color: white">Client</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-people"></i>
                    </div>
                    <a href="{{ route('coming_soon') }}" class="small-box-footer" style="color: white !important">Coming
                        soon <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner" style="background-color: #986D9A; border-color: #986D9A;">
                        <h3>{{ $storageCount }}</h3>
                        <p>Storage</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-box"></i>
                    </div>
                    <a href="{{ route('storages.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div> --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="card" style="margin-left: 2%; margin-right: 2%;">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            To Do List
                        </h3>
                        <div class="card-tools">
                            {{ $todoLists->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="todo-list" data-widget="todo-list">
                            @foreach ($todoLists as $todoList)
                                @php
                                    $deadlineDate = Carbon\Carbon::parse($todoList->deadline);
                                    $today = Carbon\Carbon::now();
                                    $oneDaysFromNow = $today->copy()->addDays(1);
                                    $isPastDate = $deadlineDate->isPast();
                                    $isWithinOneDays = $deadlineDate->between($today, $oneDaysFromNow);
                                    $yesterday = $today->copy()->subDay(); // Tanggal kemarin
                                    $isYesterdayOrBefore = $deadlineDate->lessThanOrEqualTo($yesterday);
                                @endphp
                                <li>
                                    <span>
                                        @if ($isYesterdayOrBefore)
                                            <i class="fas fa-info-circle" style="color: red;"></i>
                                        @elseif ($isPastDate)
                                            <i class="fas fa-info-circle" style="color: rgb(1, 187, 1)"></i>
                                        @elseif ($isWithinOneDays)
                                            <i class="fas fa-info-circle" style="color: rgb(241, 162, 16);;"></i>
                                        @else
                                            <i class="fas fa-info-circle"></i>
                                        @endif
                                    </span>
                                    <span class="text">{{ date('d-m-Y', strtotime($todoList->deadline)) }}</span>
                                    <span class="text"> | </span>
                                    <span style="@if ($isYesterdayOrBefore) text-decoration: line-through @endif"
                                        class="text">{{ $todoList->task }}</span>
                                    @php
                                        $userRole = Auth::check() ? Auth::user()->role->name : null;
                                    @endphp
                                    @if ($userRole === 'superadmin' || $userRole === 'admin')
                                        <div class="tools">
                                            <!-- Tautan ke halaman edit ToDo List berdasarkan ID -->
                                            <a style="color: #1d98d9" class="mr-1"
                                                href="{{ route('todo.edit', ['todo_list' => $todoList->id]) }}"><i
                                                    class="fas fa-edit"></i></a>

                                            <!-- Form untuk menghapus ToDo List berdasarkan ID -->
                                            <a style="color: #c6303e" href="#"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $todoList->id }}').submit();"><i
                                                    class="fas fa-trash"></i></a>
                                            <form id="delete-form-{{ $todoList->id }}"
                                                action="{{ route('todo.destroy', ['todo_list' => $todoList->id]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    @endif

                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if ($userRole === 'superadmin' || $userRole === 'admin')
                        <div class="card-footer clearfix">
                            <a href="{{ route('todo.create') }}" class="btn btn-primary float-right"
                                style="background-color: #C01E5E; border-color: #C01E5E;">
                                <i class="fas fa-plus"></i> Add Item
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Mendapatkan tinggi gambar menggunakan JavaScript
        var img = new Image();
        img.src = "{{ asset('images/home-banner-edit.jpg') }}";
        img.onload = function() {
            var imageDiv = document.getElementById('imageDiv');
            imageDiv.style.height = img.height + 'px';
        };

        document.addEventListener("DOMContentLoaded", function() {
            var h3 = document.querySelector("#imageDiv h3");
            var h4 = document.querySelector("#imageDiv h4");

            setTimeout(function() {
                h3.style.opacity = "1";
            }, 500); // Waktu tunda 500ms sebelum muncul h3

            setTimeout(function() {
                h4.style.opacity = "1";
            }, 1000); // Waktu tunda 1000ms sebelum muncul h4
        });
    </script>
@endsection
