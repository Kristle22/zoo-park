<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecieController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AnimalController;
use Inertia\Inertia; // rendering React components


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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})
// ->middleware(['auth', 'verified'])->name('dashboard')
; // from resources/js/Pages/{name}.jsx

// Route::inertia('/labas', 'LabasComponent');
Route::get('/labas', function () {
    return Inertia::render('Users/LabasComponent');
});

Route::get('/labas-b', function () {
    return view('labas');
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'species'], function(){
    Route::get('', [SpecieController::class, 'index'])->name('specie.index');
    Route::get('create', [SpecieController::class, 'create'])->name('specie.create');
    Route::post('store', [SpecieController::class, 'store'])->name('specie.store');
    Route::get('edit/{specie}', [SpecieController::class, 'edit'])->name('specie.edit');
    Route::post('update/{specie}', [SpecieController::class, 'update'])->name('specie.update');
    Route::post('delete/{specie}', [SpecieController::class, 'destroy'])->name('specie.destroy');
    Route::get('show/{specie}', [SpecieController::class, 'show'])->name('specie.show');
 });

 Route::group(['prefix' => 'managers'], function(){
    Route::get('', [ManagerController::class, 'index'])->name('manager.index');
    Route::get('create', [ManagerController::class, 'create'])->name('manager.create');
    Route::post('store', [ManagerController::class, 'store'])->name('manager.store');
    Route::get('edit/{manager}', [ManagerController::class, 'edit'])->name('manager.edit');
    Route::post('update/{manager}', [ManagerController::class, 'update'])->name('manager.update');
    Route::post('delete/{manager}', [ManagerController::class, 'destroy'])->name('manager.destroy');
    Route::get('show/{manager}', [ManagerController::class, 'show'])->name('manager.show');
 });
 
 Route::group(['prefix' => 'animals'], function(){
    Route::get('', [AnimalController::class, 'index'])->name('animal.index');
    Route::get('create', [AnimalController::class, 'create'])->name('animal.create');
    Route::post('store', [AnimalController::class, 'store'])->name('animal.store');
    Route::get('edit/{animal}', [AnimalController::class, 'edit'])->name('animal.edit');
    Route::post('update/{animal}', [AnimalController::class, 'update'])->name('animal.update');
    Route::post('delete/{animal}', [AnimalController::class, 'destroy'])->name('animal.destroy');
    Route::get('show/{animal}', [AnimalController::class, 'show'])->name('animal.show');
    Route::get('pdf/{animal}', [AnimalController::class, 'pdf'])->name('animal.pdf');
 });
 

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
