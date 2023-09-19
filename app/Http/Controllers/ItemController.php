<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Session;

use PDF;
use Illuminate\Support\Facades\View;

class ItemController extends Controller
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
        $query = Item::with('category')->orderByDesc('created_at');
    
        // Tambahkan kondisi jika user ingin menyertakan data yang sudah dihapus
        if ($includeDeleted) {
            $query->withTrashed();
        } else {
            // Jika checkbox tidak dicentang, filter hanya data yang belum dihapus
            $query->whereNull('deleted_at');
        }
    
        // Filter berdasarkan pencarian
        $searchKeyword = $request->input('search');
        if ($searchKeyword) {
            $query->where(function ($query) use ($searchKeyword) {
                $query->where('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('description', 'like', "%{$searchKeyword}%")
                    ->orWhereHas('category', function ($query) use ($searchKeyword) {
                        $query->where('name', 'like', "%{$searchKeyword}%");
                    });
            });
        }
    
        $query->orderByDesc('created_at');
    
        // Ambil data dengan pagination
        $items = $query->paginate(5);
    
        // Simpan status checkbox "include_deleted" ke dalam session
        $request->session()->put('include_deleted', $includeDeleted);
    
        return view('items.index', compact('items', 'searchKeyword', 'includeDeleted'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $itemCategories = ItemCategory::all();

        return view('items.create', compact('itemCategories'));
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
            'name' => 'required|unique:items',
            'description' => 'required',
            'file_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'item_category_id' => 'required',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'description.required' => 'The description field is required.',
            'file_foto.image' => 'The file must be an image.',
            'file_foto.mimes' => 'The file must be a JPEG, PNG, JPG, or GIF.',
            'file_foto.max' => 'The file size must not exceed 2048 kilobytes.',
            'item_category_id.required' => 'The item category field is required.',
        ]);
    
        try {
            if ($request->hasFile('file_foto')) {
                $file = $request->file('file_foto');
                $file_path = $file->store('images', 'public');
    
                // Ambil path public
                $public_path = Storage::url($file_path);
    
                // Simpan path public ke dalam kolom 'file_foto'
                $validatedData['file_foto'] = $public_path;
            }
    
            Item::create($validatedData);
    
            // Set pesan success ke dalam session
            Session::flash('success', 'Item created successfully.');
    
            return redirect()->route('items.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            Session::flash('error', 'Failed to create item.');
    
            return redirect()->route('items.create');
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $itemCategories = ItemCategory::all();

        return view('items.edit', compact('item', 'itemCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:items,name,' . $item->id,
            'description' => 'required',
            'file_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'item_category_id' => 'required',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'description.required' => 'The description field is required.',
            'file_foto.image' => 'The file must be an image.',
            'file_foto.mimes' => 'The file must be a JPEG, PNG, JPG, or GIF.',
            'file_foto.max' => 'The file size must not exceed 2048 kilobytes.',
            'item_category_id.required' => 'The item category field is required.',
        ]);
    
        try {
            if ($request->hasFile('file_foto')) {
                // Upload gambar baru
                $file = $request->file('file_foto');
                $file_path = $file->store('images', 'public');
                // Ambil path public
                $public_path = Storage::url($file_path);
                $validatedData['file_foto'] = $public_path;
    
                // Hapus gambar lama jika ada
                if ($item->file_foto) {
                    Storage::disk('public')->delete($item->file_foto);
                }
            } elseif ($request->has('remove_image')) {
                // Hapus gambar jika tombol "Remove" diklik
                if ($item->file_foto) {
                    Storage::disk('public')->delete($item->file_foto);
                }
                $validatedData['file_foto'] = null;
            }
    
            $item->update($validatedData);
    
            // Set pesan success ke dalam session
            Session::flash('success', 'Item updated successfully.');
    
            return redirect()->route('items.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            Session::flash('error', 'Failed to update item.');
    
            return redirect()->route('items.edit', ['item' => $item->id]);
        }
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
    
            Session::flash('success', 'Item deleted successfully.');
            return redirect()->route('items.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to delete item.');
            return redirect()->route('items.index');
        }
    }

    public function exportPdf(Request $request)
    {
        $data = Item::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('items.export_pdf');
        return $pdf->download('items.pdf');
    }

    public function restore($id)
    {
        try {
            $item = Item::withTrashed()->findOrFail($id);
            $item->restore();

            // Set pesan success ke dalam session
            session()->flash('success', 'Item restored successfully');

            return redirect()->route('items.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to restore item');

            return redirect()->route('items.index');
        }
    }
}
