<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\StorageTypeController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemLocationController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckPasswordChanged;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComingSoonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MyRoomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home'); // Use redirect method to simplify the root URL redirection

// Route untuk halaman "Page Not Found" (404)
Route::fallback(function () {
    return view('error404');
});

Route::middleware(['auth', 'password.changed'])->group(function () {

    // Route for Coming Soon page
    Route::get('/coming-soon', [ComingSoonController::class, 'index'])->name('coming_soon');

    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    
    


    // Route::resource('storage_types', StorageTypeController::class)->only(['index']);
    // Route::get('/storage_types/export-pdf', [StorageTypeController::class, 'exportPdf'])->name('storage_types.exportPDF');

    Route::resource('storages', StorageController::class)->only(['index']);
    Route::get('/storages/export-pdf', [StorageController::class, 'exportPdf'])->name('storages.exportPDF');

    Route::resource('item_categories', ItemCategoryController::class)->only(['index']);
    Route::get('/item_categories/export-pdf', [ItemCategoryController::class, 'exportPdf'])->name('item_categories.exportPDF');

    Route::resource('items', ItemController::class)->only(['index']);
    Route::get('/items/export-pdf', [ItemController::class, 'exportPdf'])->name('items.exportPDF');

    Route::resource('item_locations', ItemLocationController::class)->only(['index']);
    Route::get('/item_locations/export-pdf', [ItemLocationController::class, 'exportPdf'])->name('item_locations.exportPDF');
    

    Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
        // Routes accessible by both 'superadmin' and 'admin' roles
        // Route::resource('storage_types', StorageTypeController::class)->except(['index']);
        // Route::patch('/storage_types/{storage_type}/restore', [StorageTypeController::class , 'restore'])->name('storage_types.restore');

        Route::resource('storages', StorageController::class)->except(['index']);
        Route::patch('/storages/{storage}/restore', [StorageController::class , 'restore'])->name('storages.restore');

        Route::resource('item_categories', ItemCategoryController::class)->except(['index']);
        Route::patch('/item_categories/{item_category}/restore', [ItemCategoryController::class , 'restore'])->name('item_categories.restore');

        Route::resource('items', ItemController::class)->except(['index']);
        Route::patch('/items/{item}/restore', [ItemController::class , 'restore'])->name('items.restore');

        Route::resource('item_locations', ItemLocationController::class)->except(['index']);
        Route::patch('/item_locations/{item_location}/restore', [ItemLocationController::class , 'restore'])->name('item_locations.restore');
        Route::get('/item_locations/create/{item_id}/{storage_id}', [ItemLocationController::class, 'createWithDefaultData'])
    ->name('item_locations.createWithDefaultData');


        Route::get('/todo/create', [TodoListController::class, 'create'])->name('todo.create');
        Route::post('/todo', [TodoListController::class, 'store'])->name('todo_lists.store');
        Route::get('/todo/{todo_list}/edit', [TodoListController::class, 'edit'])->name('todo.edit');
        Route::put('/todo/{todo_list}', [TodoListController::class, 'update'])->name('todo.update');
        Route::delete('/todo/{todo_list}', [TodoListController::class, 'destroy'])->name('todo.destroy');

        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
        Route::get('/rooms/{room_id}/export-pdf', [RoomController::class, 'exportPdf'])->name('rooms.exportPDF');

    });
    
    Route::middleware('role:superadmin')->group(function () {
        // Routes accessible only by the 'superadmin' role
        Route::resource('users', UserController::class);
        Route::get('/profile/edit/{user}', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware('role:therapist')->group(function () {
        // Routes accessible only by the 'therapist' role
        Route::get('/myrooms', [MyRoomController::class, 'index'])->name('myrooms.index');
        Route::get('/myrooms/{room}', [MyRoomController::class, 'show'])->name('myrooms.show');
        Route::get('/myrooms/{room_id}/export-pdf', [MyRoomController::class, 'exportPdf'])->name('myrooms.exportPDF');
    });

    Route::middleware('role:admin')->group(function () {
        // Routes accessible only by the 'admin' role
    });

    // Logout route
    Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthLoginController::class, 'login']);
});
