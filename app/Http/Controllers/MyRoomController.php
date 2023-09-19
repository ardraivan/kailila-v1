<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;
use App\Models\Item;
use PDF;

class MyRoomController extends Controller
{
    public function index()
    {
        // Ambil data ruangan milik terapis yang sedang login
        $therapyRooms = Storage::where('user_id', auth()->user()->id)
            ->whereHas('storageType', function ($query) {
                $query->where('name', 'Therapy Room');
            })
            ->with('user', 'colour')
            ->get();

        // Kirim data yang diperlukan ke view
        return view('myrooms.index', compact('therapyRooms'));
    }

    public function show($id)
    {
        // Ambil data room berdasarkan ID dengan eager load data item_locations dan items
        $room = Storage::with(['itemLocations.item'])->findOrFail($id);

        // Pastikan user yang sedang login adalah pemilik ruangan (terapis)
        if ($room->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        // Ambil semua item dari database dengan pagination (10 data per halaman)
        $query = Item::query();

        // Proses pencarian jika ada query string "search" dari permintaan
        if (request()->has('search')) {
            $searchKeyword = '%' . request()->query('search') . '%';
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'like', $searchKeyword)
                    ->orWhere('description', 'like', $searchKeyword)
                    ->orWhereHas('category', function ($subQ) use ($searchKeyword) {
                        $subQ->where('name', 'like', $searchKeyword);
                    });
            });
        }

        // Lakukan paginasi setelah proses pencarian
        $items = $query->paginate(10);

        // Siapkan array untuk menyimpan kuantitas item untuk ruangan tertentu
        $itemQuantities = [];

        // Inisialisasi kuantitas item menjadi 0 untuk semua item
        foreach ($items as $item) {
            $itemQuantities[$item->name] = 0;
        }

        // Hitung kuantitas item untuk ruangan tertentu
        foreach ($room->itemLocations as $itemLocation) {
            $itemName = $itemLocation->item->name;
            $itemQuantities[$itemName] = $itemLocation->quantity;
        }

        // Kirim data yang diperlukan ke view
        return view('myrooms.detail', [
            'room' => $room,
            'items' => $items,
            'itemQuantities' => $itemQuantities,
            'storage_id' => $id,
        ]);
    }

    public function exportPdf(Request $request)
    {
        // Ambil semua item dari database
        $items = Item::all();

        // Ambil data room berdasarkan ID dengan eager load data item_locations dan items
        $room = Storage::with(['itemLocations.item'])->findOrFail($request->room_id);

        // Pastikan user yang sedang login adalah pemilik ruangan (terapis)
        if ($room->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        // Siapkan array untuk menyimpan data item yang akan ditampilkan di PDF
        $data = [];

        foreach ($items as $item) {
            $itemLocation = $room->itemLocations->where('item_id', $item->id)->first();
            $quantity = $itemLocation ? $itemLocation->quantity : 0;

            $data[] = [
                'name' => $item->name,
                'description' => $item->description,
                'category' => $item->category ? $item->category->name : 'Data Unavailable',
                'quantity' => $quantity,
                'last_update' => $item->updated_at->setTimezone('Asia/Jakarta')->format('d M Y H:i'),
            ];
        }

        // Load view PDF dan kirim data yang diperlukan ke view
        view()->share([
            'data' => $data,
            'room' => $room,
        ]);

        $pdf = PDF::loadview('myrooms.export_pdf');
        return $pdf->download($room->name . '.pdf');
    }
}
