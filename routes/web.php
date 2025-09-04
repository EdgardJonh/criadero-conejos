<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    return view('admin.menu');
})->middleware('auth')->name('admin.menu');

Route::middleware(['auth'])->group(function () {
    Route::resource('conejos', App\Http\Controllers\ConejoController::class);
    Route::resource('manejo-sanitario', App\Http\Controllers\ManejoSanitarioController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Endpoint público para obtener todos los conejos en JSON
Route::get('/api/conejos', function () {
    return \App\Models\Conejo::all();
});

// Eliminar foto adicional guardada de un conejo
Route::post('conejos/{conejo}/delete-foto', function($conejoId) {
    $conejo = \App\Models\Conejo::findOrFail($conejoId);
    $foto = request('foto');
    $fotos = $conejo->fotos_adicionales ?? [];
    if(($key = array_search($foto, $fotos)) !== false) {
        unset($fotos[$key]);
        $conejo->fotos_adicionales = array_values($fotos);
        $conejo->save();
        \Illuminate\Support\Facades\Storage::disk('public')->delete($foto);
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
});

require __DIR__.'/auth.php';
