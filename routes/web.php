<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Groups;
use App\Http\Controllers\Products;
use App\Http\Controllers\Catalog\Products as cProducts;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/tables', function () {
    return view('tables');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix("catalog")->group(function () {
    Route::get('/products', [cProducts::class, 'index']);
});

Route::prefix("admin")->middleware('auth')->group(function () {
//    Route::resource('products', Products::class);
//    Route::resource('groups', Groups::class);

    Route::get('/', function (){
        return view('admin.catalog.home');
    })->name('admin.home');

    Route::get('/products', [Products::class, 'index'])->name('products.index');
    Route::get('/products/create', [Products::class, 'create'])->name('products.create');
    Route::get('/products/{id}/edit', [Products::class, 'edit'])->name('products.edit');
    Route::post('/products/{id}', [Products::class, 'update'])->name('products.update');
    Route::post('/products/', [Products::class, 'store'])->name('products.store');

    Route::get('/groups', [Groups::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [Groups::class, 'create'])->name('groups.create');
    Route::get('/groups/{id}/edit', [Groups::class, 'edit'])->name('groups.edit');
    Route::post('/groups/{id}', [Groups::class, 'update'])->name('groups.update');
    Route::post('/groups/', [Groups::class, 'store'])->name('groups.store');
});

require __DIR__.'/auth.php';
