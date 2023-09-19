<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use App\Models\Item;
use App\Models\Storage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah data items dari database
        $itemCount = Item::count();

        // Mengambil jumlah data storages dari database
        $storageCount = Storage::count();

        // Mengambil data ToDo List dengan pagination
        $todoLists = ToDoList::orderBy('deadline', 'asc')->paginate(5);

        // Anda bisa menambahkan logika lainnya sesuai kebutuhan

        return view('dashboard', compact('itemCount', 'storageCount', 'todoLists'));
    }
}

