<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\ProductosController;
use App\Models\User;
use App\Models\Marcas;
use App\Models\Productos;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $totalUsuarios = User::count();
    $totalMarcas = Marcas::count();
    $totalProductos = Productos::count();

    return Inertia::render('Dashboard', [
        'totalUsuarios' => $totalUsuarios,
        'totalMarcas' => $totalMarcas,
        'totalProductos' => $totalProductos,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Marcas
    Route::resource('marcas', MarcasController::class);

    // Rutas de Productos
    Route::resource('productos', ProductosController::class);
    Route::post('updateProducto', [ProductosController::class, 'updateproducto'])->name('updateproducto');
});

require __DIR__.'/auth.php';
