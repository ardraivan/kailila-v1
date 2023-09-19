@extends('layouts.app')

@section('title')
    Room Details
@endsection

@section('isRoomPage', true)

@section('roomColourHexcode', $room->colour->hexcode) {{-- Menyimpan room colour hexcode --}}

@section('breadcrumb')
    <li class="breadcrumb-item"><a style="color: #C01A5B" href="{{ route('myrooms.index') }}">My Rooms</a></li>
    <li class="breadcrumb-item active">{{ $room->name }}</li>
@endsection

@section('content')
    <div class="container">
        <div class="card">

            <div class="card-header d-flex justify-content-between my-2">
                <div class="input-group input-group-sm flex-grow-1" style="width: 300px;">
                    <form action="{{ route('rooms.show', ['room' => $room->id]) }}" method="GET">
                        <!-- Menggunakan method GET untuk mengirimkan query string "search" -->
                        <input class="form-control" type="text" id="search-input" name="search" placeholder="Search..."
                            value="{{ request()->query('search') }}">
                    </form>
                </div>
                <div class="card-tools align-items-center mr-2 d-none d-sm-flex">
                    <h3 class="card-title" style="font-weight: bold">{{ $room->name }}</h3>
                    <h3 class="card-title ml-2">|</h3>
                    <h3 class="card-title ml-2">{{ $room->user->name }}</h3>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            @php
                                // Mendapatkan nilai RGB dari hexcode
                                [$r, $g, $b] = sscanf($room->colour->hexcode, '#%02x%02x%02x');
                                // Menghitung tingkat kecerahan warna (0-255), semakin tinggi semakin terang
                                $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
                                // Jika tingkat kecerahan > 125, maka warna teks hitam, jika tidak maka putih
                                $textColor = $brightness > 125 ? 'black' : 'white';
                            @endphp
                            <tr style="border: 1px solid {{ $textColor }};">
                                <th
                                    style="border: 1px solid {{ $textColor }}; width: 5%; background-color: {{ $room->colour->hexcode }}; color: {{ $textColor }}">
                                    #</th>
                                <th
                                    style="border: 1px solid {{ $textColor }}; background-color: {{ $room->colour->hexcode }}; color: {{ $textColor }}">
                                    Name
                                </th>
                                <th
                                    style="border: 1px solid {{ $textColor }}; background-color: {{ $room->colour->hexcode }}; color: {{ $textColor }}">
                                    Category</th>
                                <th
                                    style="border: 1px solid {{ $textColor }}; background-color: {{ $room->colour->hexcode }}; color: {{ $textColor }}">
                                    Description</th>
                                <th
                                    style="border: 1px solid {{ $textColor }}; background-color: {{ $room->colour->hexcode }}; color: {{ $textColor }}">
                                    Quantity</th>
                                <th
                                    style="border: 1px solid {{ $textColor }}; background-color: {{ $room->colour->hexcode }}; color: {{ $textColor }}">
                                    Last Update</th>
                                <th
                                    style="border: 1px solid {{ $textColor }}; width: 10%; background-color: {{ $room->colour->hexcode }}; color: {{ $textColor }}">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Hitung nomor urut mulai dari nomor halaman yang sedang aktif --}}
                            @php
                                $startIndex = ($items->currentPage() - 1) * $items->perPage() + 1;
                            @endphp

                            @foreach ($items as $index => $item)
                                <tr style="border: 1.2px solid #000;">
                                    {{-- Tampilkan nomor urut sesuai dengan nomor halaman yang sedang aktif --}}
                                    <td style="border: 1.2px solid #000;">{{ $startIndex + $index }}</td>
                                    <td style="border: 1.2px solid #000;">{{ $item->name }}</td>
                                    <td style="border: 1.2px solid #000;">
                                        {{ $item->category ? $item->category->name : 'Data Unavailable' }}</td>
                                    <td style="border: 1.2px solid #000;">{{ $item->description }}</td>
                                    <td style="border: 1.2px solid #000;">{{ $itemQuantities[$item->name] }}</td>
                                    <td style="border: 1.2px solid #000;">
                                        {{ $item->updated_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}
                                    </td>
                                    <td style="border: 1.2px solid #000;">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Tambahkan bagian pagination pada bagian card-footer -->
        <div class="card-footer clearfix">
            <div class="float-left">
                {{ $items->appends(request()->query())->links('pagination::bootstrap-4') }} <!-- Menampilkan pagination -->
            </div>
            <div class="float-right">
                <a href="{{ route('myrooms.exportPDF', ['room_id' => $room->id, 'search' => request()->query('search')]) }}"
                    class="btn btn-sm btn-info">
                    Export to PDF
                </a>
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection
