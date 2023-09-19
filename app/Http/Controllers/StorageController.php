<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use App\Models\StorageType;
use App\Models\Colour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use PDF;
use Illuminate\Support\Facades\View;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Storage::query();
    
        // Get the include_deleted value from the request
        $includeDeleted = $request->input('include_deleted', false);
    
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
                    ->orWhereHas('storageType', function ($query) use ($searchKeyword) {
                        $query->where('name', 'like', "%{$searchKeyword}%");
                    });
            });
        }
    
        $query->orderByDesc('created_at');
    
        // Ambil data dengan pagination
        $storages = $query->paginate(5);
    
        // Simpan status checkbox "include_deleted" ke dalam session
        $request->session()->put('include_deleted', $includeDeleted);
    
        return view('storages.index', compact('storages', 'searchKeyword', 'includeDeleted'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storageTypes = StorageType::all();
        $colours = Colour::all();
        $users = User::all();
    
        return view('storages.create', compact('storageTypes', 'colours', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'storage_type_id' => 'required',
        
        'name' => [
            'required',
            
    
    Rule::unique('storages')->where(function ($query) {
        $query->whereNull('deleted_at'); // Tambahkan kondisi whereNull untuk memastikan data yang dihapus tidak ikut dalam validasi unique
    }),
        ],
        'colour_id' => [
            'nullable',
            'required_if:storage_type_id,' . StorageType::where('name', 'Therapy Room')->value('id'),
            function ($attribute, $value, $fail) use ($request) {
                // Cek apakah warna sudah digunakan oleh storage lain
                if (!empty($value)) {
                    $isColorUsed = Storage::where('colour_id', $value)->exists();
                    if ($isColorUsed) {
                        $fail('The selected colour is already used by another storage.');
                    }
                }
            },
        ],
        'user_id' => 'nullable|required_if:storage_type_id,' . StorageType::where('name', 'Therapy Room')->value('id'),
    ], [
        'storage_type_id.required' => 'The storage type field is required.',
        'name.required' => 'The name field is required.',
        'name.unique' => 'The name has already been taken.',
        'colour_id.required_if' => 'The colour field is required when storage type is Therapy Room.',
        'user_id.required_if' => 'The user field is required when storage type is Therapy Room.',
        'colour_id.unique' => 'The selected colour is already used by another storage.',
    ]);

    // Check if the selected user already has another Therapy Room storage
    $user_id = $request->input('user_id');
    $user = User::find($user_id);
    $role = $user ? $user->role->name : null;

    if ($role === 'therapist') {
        $userTherapyRoomStorages = Storage::where('user_id', $user_id)
            ->whereHas('storageType', function ($query) {
                $query->where('name', 'Therapy Room');
            })->get();

        if ($userTherapyRoomStorages->count() > 0) {
            return redirect()->route('storages.create')->with('error', 'This role can only have one Therapy Room storage.');
        }
    }

    // Create the storage
    try {
        Storage::create([
            'name' => $request->name,
            'storage_type_id' => $request->storage_type_id,
            'colour_id' => $request->colour_id,
            'user_id' => $user_id,
        ]);

        // Set pesan success ke dalam session
        Session::flash('success', 'Storage created successfully');

        return redirect()->route('storages.index');
    } catch (\Exception $e) {
        // Set pesan error ke dalam session
        Session::flash('error', 'Failed to create storage');

        return redirect()->route('storages.create');
    }
}
    
    
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function show(Storage $storage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storage = Storage::findOrFail($id);
        $storageTypes = StorageType::all();
        $colours = Colour::all();
        $users = User::all();
    
        return view('storages.edit', compact('storage', 'storageTypes', 'colours', 'users'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Storage $storage)
    {
        $request->validate([
            'storage_type_id' => 'required',
            'name' => [
                'required',
                Rule::unique('storages')->where(function ($query) {
                    $query->whereNull('deleted_at');
                })->ignore($storage->id),
            ],
            'colour_id' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request, $storage) {
                    // Cek apakah warna sudah digunakan oleh storage lain, kecuali storage yang sedang diupdate
                    if (!empty($value)) {
                        $isColorUsed = Storage::where('colour_id', $value)
                            ->where('id', '<>', $storage->id)
                            ->exists();
    
                        if ($isColorUsed) {
                            $fail('The selected colour is already used by another storage.');
                        }
                    }
                },
            ],
            'user_id' => 'nullable|required_if:storage_type_id,' . StorageType::where('name', 'Therapy Room')->value('id'),
        ], [
            'storage_type_id.required' => 'The storage type field is required.',
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'colour_id.required_if' => 'The colour field is required when storage type is Therapy Room.',
            'user_id.required_if' => 'The user field is required when storage type is Therapy Room.',
            'colour_id.unique' => 'The selected colour is already used by another storage.',
        ]);
    
        // Check if the selected user already has another Therapy Room storage
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $role = $user ? $user->role->name : null;
    
        if ($role === 'therapist') {
            $userTherapyRoomStorages = Storage::where('user_id', $user_id)
                ->whereHas('storageType', function ($query) {
                    $query->where('name', 'Therapy Room');
                })
                ->where('id', '<>', $storage->id) // Mengabaikan validasi pada storage yang sedang diupdate
                ->get();
    
            if ($userTherapyRoomStorages->count() > 0) {
                return redirect()->route('storages.edit', ['storage' => $storage->id])->with('error', 'This role can only have one Therapy Room storage.');
            }
        }
    
        // Update the storage
        try {
            $storageType = StorageType::findOrFail($request->storage_type_id);
    
            // Set user_id and colour_id to null if the storage type is not "Therapy Room"
            if ($storageType->name !== 'Therapy Room') {
                $request->merge(['user_id' => null, 'colour_id' => null]);
            }
    
            $storage->update([
                'name' => $request->name,
                'storage_type_id' => $request->storage_type_id,
                'colour_id' => $request->colour_id,
                'user_id' => $request->user_id,
            ]);
    
            // Set pesan success ke dalam session
            Session::flash('success', 'Storage updated successfully');
    
            return redirect()->route('storages.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            Session::flash('error', 'Failed to update storage');
    
            return redirect()->route('storages.edit', ['storage' => $storage->id]);
        }
    }
    
    
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storage $storage)
    {

        try {
            $storage->delete();
            // Set pesan success ke dalam session
            session()->flash('success', 'Storage deleted successfully');
    
            return redirect()->route('storages.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to delete storage');
    
            return redirect()->route('storages.index');
        }

    }

    public function exportPdf(Request $request)
    {
        $data = Storage::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('storages.export_pdf');
        return $pdf->download('storages.pdf');
    }

    public function restore($id)
    {
        try {
            $storage = Storage::withTrashed()->findOrFail($id);
            $storage->restore();

            // Set pesan success ke dalam session
            session()->flash('success', 'Storage restored successfully');

            return redirect()->route('storages.index');
        } catch (\Exception $e) {
            // Set pesan error ke dalam session
            session()->flash('error', 'Failed to restore storage');

            return redirect()->route('storages.index');
        }
    }
}
