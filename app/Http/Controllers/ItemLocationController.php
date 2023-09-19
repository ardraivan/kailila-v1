<?php

namespace App\Http\Controllers;

use App\Models\ItemLocation;
use App\Models\Storage;
use App\Models\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Illuminate\Validation\Rule;

use PDF;
use Illuminate\Support\Facades\View;

class ItemLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the include_deleted value from the request
        $includeDeleted = $request->input('include_deleted', false);
    
        // Get the query without pagination to avoid conflicts with the search query
        $query = ItemLocation::query();
    
        // Tambahkan kondisi jika user ingin menyertakan data yang sudah dihapus
        if ($includeDeleted) {
            $query->withTrashed();
        } else {
            // Jika checkbox tidak dicentang, filter hanya data yang belum dihapus
            $query->whereHas('item', function ($query) {
                $query->whereNull('deleted_at');
            })->whereHas('storage', function ($query) {
                $query->whereNull('deleted_at');
            });
        }
    
        // Filter berdasarkan pencarian
        $searchKeyword = $request->input('search');
        if ($searchKeyword) {
            $query->where(function ($query) use ($searchKeyword) {
                $query->orWhereHas('item', function ($query) use ($searchKeyword) {
                    $query->where('name', 'like', "%{$searchKeyword}%");
                })->orWhereHas('storage', function ($query) use ($searchKeyword) {
                    $query->where('name', 'like', "%{$searchKeyword}%");
                });
            });
        }
    
        $query->orderByDesc('created_at');
    
        // Ambil data dengan pagination
        $itemLocations = $query->paginate(5);
    
        // Simpan status checkbox "include_deleted" ke dalam session
        $request->session()->put('include_deleted', $includeDeleted);
    
        return view('item_locations.index', compact('itemLocations', 'searchKeyword', 'includeDeleted'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        $storages = Storage::all();
        return view('item_locations.create', compact('items', 'storages'));
    }

    public function createWithDefaultData($item_id, $storage_id)
    {
        // Ambil data item dan storage berdasarkan ID
        $items = Item::findOrFail($item_id);
        $storages = Storage::findOrFail($storage_id);
        
        // Gunakan View::share untuk mengirimkan data default ke view secara global
        View::share('defaultItem', $items);
        View::share('defaultStorage', $storages);
    
        // Kirim data yang diperlukan ke view
        return view('item_locations.create', compact('items', 'storages'));
    }
    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => [
                'required',
                Rule::unique('item_locations')->where(function ($query) use ($request) {
                    return $query->where('storage_id', $request->storage_id);
                }),
            ],
            'storage_id' => 'required',
            'quantity' => 'required',
        ], [
            'item_id.unique' => 'An item with this combination of item and storage already exists.',
        ]);
    
        try {
            ItemLocation::create($validatedData);
    
            Session::flash('success', 'Item location created successfully.');
    
            return redirect()->route('item_locations.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to create item location.');
    
            return redirect()->route('item_locations.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemLocation  $itemLocation
     * @return \Illuminate\Http\Response
     */
    public function show(ItemLocation $itemLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemLocation  $itemLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemLocation $itemLocation)
    {
        $items = Item::all();
        $storages = Storage::all();
        return view('item_locations.edit', compact('itemLocation', 'items', 'storages'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemLocation  $itemLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemLocation $itemLocation)
    {
        $validatedData = $request->validate([
            'item_id' => [
                'required',
                Rule::unique('item_locations')->ignore($itemLocation->id)->where(function ($query) use ($request) {
                    return $query->where('storage_id', $request->storage_id);
                }),
            ],
            'storage_id' => 'required',
            'quantity' => 'required',
        ], [
            'item_id.unique' => 'An item with this combination of item and storage already exists.',
        ]);
    
        try {
            $itemLocation->update($validatedData);
    
            Session::flash('success', 'Item location updated successfully.');
    
            return redirect()->route('item_locations.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to update item location.');
    
            return redirect()->route('item_locations.edit', ['item_location' => $itemLocation->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemLocation  $itemLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemLocation $itemLocation)
    {
        try {
            $itemLocation->delete();
            Session::flash('success', 'Item location deleted successfully');

            return redirect()->route('item_locations.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to delete item location');

            return redirect()->route('item_locations.index');
        }
    }

    public function exportPdf(Request $request)
    {
        $data = ItemLocation::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('item_locations.export_pdf');
        return $pdf->download('item-locations.pdf');
    }

    public function restore($id)
    {
        try {
            $itemLocation = ItemLocation::withTrashed()->findOrFail($id);
            $itemLocation->restore();

            // Set pesan success ke dalam session
            session()->flash('success', 'Item Location restored successfully');

            return redirect()->route('item_locations.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to restore item location');

            return redirect()->route('item_locations.index');
        }
    }
}
