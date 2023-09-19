<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use PDF;
use Illuminate\Support\Facades\View;

class ItemCategoryController extends Controller
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
        $query = ItemCategory::query();
    
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
            $query->where('name', 'like', "%{$searchKeyword}%");
        }
    
        $query->orderByDesc('created_at');
    
        // Ambil data dengan pagination
        $itemCategories = $query->paginate(5);
    
        // Simpan status checkbox "include_deleted" ke dalam session
        $request->session()->put('include_deleted', $includeDeleted);
    
        return view('item_categories.index', compact('itemCategories', 'searchKeyword', 'includeDeleted'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item_categories.create');
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
            'name' => 'required|unique:item_categories',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
        ]);
    
        try {
            ItemCategory::create($validatedData);
    
            // Set pesan success ke dalam session
            Session::flash('success', 'Item Category created successfully');
    
            return redirect()->route('item_categories.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            Session::flash('error', 'Failed to create item category');
    
            return redirect()->route('item_categories.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ItemCategory $itemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemCategory $itemCategory)
    {
        return view('item_categories.edit', compact('itemCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemCategory $itemCategory)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:item_categories,name,' . $itemCategory->id,
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
        ]);
    
        try {
            $itemCategory->update($validatedData);
    
            // Set pesan success ke dalam session
            Session::flash('success', 'Item Category updated successfully');
    
            return redirect()->route('item_categories.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            Session::flash('error', 'Failed to update item category');
    
            return redirect()->route('item_categories.edit', ['item_category' => $itemCategory->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemCategory  $itemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemCategory $itemCategory)
    {
        try {
            // Hapus storage type
            $itemCategory->delete();
    
            // Set pesan success ke dalam session
            session()->flash('success', 'Item Category deleted successfully');
    
            return redirect()->route('item_categories.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to delete item category');
    
            return redirect()->route('item_categories.index');
        }
    }

    public function exportPdf(Request $request)
    {
        $data = ItemCategory::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('item_categories.export_pdf');
        return $pdf->download('item-categories.pdf');
    }

    public function restore($id)
    {
        try {
            $itemCategory = ItemCategory::withTrashed()->findOrFail($id);
            $itemCategory->restore();

            // Set pesan success ke dalam session
            session()->flash('success', 'Item Category restored successfully');

            return redirect()->route('item_categories.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to restore item category');

            return redirect()->route('item_categories.index');
        }
    }
}
