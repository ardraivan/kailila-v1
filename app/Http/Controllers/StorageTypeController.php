<?php

namespace App\Http\Controllers;

use App\Models\StorageType;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use PDF;
use Illuminate\Support\Facades\View;

class StorageTypeController extends Controller
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
        $query = StorageType::query();
    
        // Tambahkan kondisi jika user ingin menyertakan data yang sudah dihapus
        if ($includeDeleted) {
            $query->withTrashed();
        } else {
            // Jika checkbox tidak dicentang, filter hanya data yang belum dihapus
            $query->whereNull('deleted_at');
        }
    
        // Filter berdasarkan pencarian
        $searchKeyword = null;
    
        if ($request->has('search')) {
            $searchKeyword = $request->input('search');
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('description', 'like', "%{$searchKeyword}%");
            });
        }
    
        $query->orderByDesc('created_at');
    
        // Ambil data dengan pagination
        $storageTypes = $query->paginate(5);
    
        // Simpan status checkbox "include_deleted" ke dalam session
        $request->session()->put('include_deleted', $includeDeleted);
    
        return view('storage_types.index', compact('storageTypes', 'searchKeyword', 'includeDeleted'));
    }
    
    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('storage_types.create');
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
            'name' => 'required|unique:storage_types',
            'description' => 'required',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'description.required' => 'The description field is required.',
        ]);
    
        try {
            StorageType::create($validatedData);
    
            // Set pesan success ke dalam session
            Session::flash('success', 'Storage Type created successfully');
    
            return redirect()->route('storage_types.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            Session::flash('error', 'Failed to create storage type');
    
            return redirect()->route('storage_types.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StorageType  $storageType
     * @return \Illuminate\Http\Response
     */
    public function show(StorageType $storageType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StorageType  $storageType
     * @return \Illuminate\Http\Response
     */
    public function edit(StorageType $storageType)
    {
        return view('storage_types.edit', compact('storageType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StorageType  $storageType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StorageType $storageType)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:storage_types,name,' . $storageType->id,
            'description' => 'required',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'description.required' => 'The description field is required.',
        ]);
    
        try {
            $storageType->update($validatedData);
    
            // Set pesan success ke dalam session
            Session::flash('success', 'Storage Type updated successfully');
    
            return redirect()->route('storage_types.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            Session::flash('error', 'Failed to update storage type');
    
            return redirect()->route('storage_types.edit', ['storage_type' => $storageType->id]);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StorageType  $storageType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StorageType $storageType)
    {
        try {
            // Hapus storage type
            $storageType->delete();
    
            // Set pesan success ke dalam session
            session()->flash('success', 'Storage Type deleted successfully');
    
            return redirect()->route('storage_types.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to delete storage type');
    
            return redirect()->route('storage_types.index');
        }
    }

    public function exportPdf(Request $request)
    {
        $data = StorageType::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('storage_types.export_pdf');
        return $pdf->download('storage-type.pdf');
    }

    public function restore($id)
    {
        try {
            $storageType = StorageType::withTrashed()->findOrFail($id);
            $storageType->restore();

            // Set pesan success ke dalam session
            session()->flash('success', 'Storage Type restored successfully');

            return redirect()->route('storage_types.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to restore storage type');

            return redirect()->route('storage_types.index');
        }
    }
}
