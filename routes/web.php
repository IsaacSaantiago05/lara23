<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ctrlDatos;
use App\Http\Controllers\ctrlProductos;
use App\Http\Controllers\ctrlCategorias;
use App\Http\Controllers\ctrlTenis;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/datos', [ctrlDatos::class, 'AccesoDatosVista']);


Route::get('/datoslink', [ctrlDatos::class, 'AccesoDatosLink']);

Route::get('/datosapi', [ctrlDatos::class, 'AccesoApi']);

Route::get('/datosapimia', [ctrlDatos::class, 'AccesoApiMia']);

Route::get('/tenis', [ctrlTenis::class, 'vista'])->name('Tenis');
Route::get('/tenis-json', [ctrlTenis::class, 'json'])->name('Tenis.json');
Route::get('/tenis/create', [ctrlTenis::class, 'create'])->name('Tenis.create');
Route::post('/tenis', [ctrlTenis::class, 'store'])->name('Tenis.store');
Route::get('/tenis/{id}/edit', [ctrlTenis::class, 'edit'])->name('Tenis.edit');
Route::put('/tenis/{id}', [ctrlTenis::class, 'update'])->name('Tenis.update');
Route::delete('/tenis/{id}', [ctrlTenis::class, 'destroy'])->name('Tenis.destroy');
Route::redirect('/autos', '/tenis', 301);

//vista de detalle de registro
Route::get('/detalle-api/{position}', [ctrlDatos::class, 'detalle'])->name('tj.detalle');

Route::get('/Productos', [ctrlProductos::class, 'Productos'])->name('Productos');
Route::redirect('/productos', '/Productos', 301);

Route::get('/Productos/create', [ctrlProductos::class, 'create'])->name('Productos.create');
Route::post('/Productos', [ctrlProductos::class, 'store'])->name('Productos.store');
Route::get('/Productos/buscar', [ctrlProductos::class, 'buscarId'])->name('Productos.buscar');
Route::get('/Productos/{product}', [ctrlProductos::class, 'show'])->name('Productos.show');
Route::get('/Productos/{product}/edit', [ctrlProductos::class, 'edit'])->name('Productos.edit');
Route::put('/Productos/{product}', [ctrlProductos::class, 'update'])->name('Productos.update');
Route::delete('/Productos/{product}', [ctrlProductos::class, 'destroy'])->name('Productos.destroy');


Route::get('/Categorias', [ctrlCategorias::class, 'Categorias'])->name('Categorias');
Route::redirect('/categorias', '/Categorias', 301);
Route::get('/Categorias/create', [ctrlCategorias::class, 'create'])->name('Categorias.create');
Route::post('/Categorias', [ctrlCategorias::class, 'store'])->name('Categorias.store');
Route::get('/Categorias/buscar', [ctrlCategorias::class, 'buscarId'])->name('Categorias.buscar');
Route::get('/Categorias/{category}', [ctrlCategorias::class, 'show'])->name('Categorias.show');
Route::get('/Categorias/{category}/edit', [ctrlCategorias::class, 'edit'])->name('Categorias.edit');
Route::put('/Categorias/{category}', [ctrlCategorias::class, 'update'])->name('Categorias.update');
Route::delete('/Categorias/{category}', [ctrlCategorias::class, 'destroy'])->name('Categorias.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
