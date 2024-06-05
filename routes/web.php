<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/mypc', function () {
    if (optional(Auth::user())->can('build pc') || !Auth::user()) {
        return view('user.mypc');
    } else {
        return redirect()->route('dashboard');
    }
})->name('mypc');

Route::get('/parts', function () {
    return view('parts');
})->name('parts')->withTrashed();

Route::get('/create_parts', function () {
    if (Auth::user() || isset(Auth::user()->id)) {
        return view('crudpcparts');
    } else {
        return redirect()->route('dashboard');
    }
})->name('crudpcparts');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/users', function () {
        return view('users');
    })->name('users');
});

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout')->middleware('permission:build pc');


Route::get('/part/{parttype}', function () {
    return view('part');
})->name('part')->withTrashed();

Route::get('/crud', function () {
    if (Auth::user()->can('add products')) {
        return view('crud');
    } else {
        return redirect()->route('dashboard');
    }
})->name('crud')->middleware('permission:add products');

