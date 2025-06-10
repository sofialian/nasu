<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Task
// routes/web.php
Route::middleware(['auth'])->group(function () {
    // Tareas
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])
        ->name('tasks.toggle')
        ->middleware('auth');



    // Proyectos
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // Checklists (si es necesario)
    Route::post('/tasks/{task}/checklists', [ChecklistController::class, 'store'])->name('checklists.store');
    Route::put('/checklists/{checklist}', [ChecklistController::class, 'update'])->name('checklists.update');
    Route::delete('/checklists/{checklist}', [ChecklistController::class, 'destroy'])->name('checklists.destroy');
});


//Room
Route::get('/room', [HomeController::class, 'room'])->name('room');
Route::post('/room', [HomeController::class, 'updateRoom'])->name('room.edit');

// Add these if they don't exist
Route::middleware(['auth'])->group(function () {
    // Room routes
    Route::get('/room', [App\Http\Controllers\RoomController::class, 'show'])->name('room.show');
    Route::get('/room/edit', [App\Http\Controllers\RoomController::class, 'edit'])->name('room.edit');
    Route::post('/room/update', [App\Http\Controllers\RoomController::class, 'update'])->name('room.update');

    // For adding furniture (if needed)
    Route::post('/room/add-item', [App\Http\Controllers\RoomController::class, 'addItem'])->name('room.add-item');
});

// In routes/web.php
Route::middleware(['auth'])->group(function () {
    // Furniture store
    Route::get('/furniture-store', [RoomController::class, 'showStore'])->name('furniture.store');
    Route::post('/room/add-furniture', [RoomController::class, 'addFurniture'])->name('room.add-furniture');
    Route::delete('/room/remove-furniture/{index}', [RoomController::class, 'removeFurniture'])->name('room.remove-furniture');
});

Route::middleware('auth')->group(function () {
    Route::get('/room/{room}', [RoomController::class, 'show'])->name('room.show');
    Route::post('/room/{room}/items', [RoomController::class, 'placeItem'])->name('room.items.store');
    Route::delete('/items/{item}', [RoomController::class, 'removeItem'])->name('room.items.destroy');
});

Route::middleware('auth')->group(function () {
    // Room routes
    // Route::get('/room/{room}', [RoomController::class, 'show'])->name('room.show');
    Route::post('/room/{room}/place-item', [RoomController::class, 'placeItem'])->name('room.place');
    Route::delete('/room/remove-item/{item}', [RoomController::class, 'removeItem'])->name('room.remove');
});

// routes/web.php
Route::get('/room/{room}/edit', [RoomController::class, 'edit'])->name('room.edit');
Route::put('/room/{room}/items', [RoomController::class, 'updateItems'])->name('room.update-items');


require __DIR__ . '/auth.php';
