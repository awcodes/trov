<?php

use Trov\Livewire\Profile;
use Trov\Livewire\EditUser;
use Trov\Livewire\UserIndex;
use Trov\Livewire\CreateUser;

Route::get('/home', function () {
    return redirect(config('trov.home'));
});

Route::prefix('trov')->middleware(['web', 'auth'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('trov.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('trov::dashboard');
    })->name('trov.dashboard');

    Route::get('/users', UserIndex::class)->name('trov.users.index');
    Route::get('/users/create', CreateUser::class)->name('trov.users.create');
    Route::get('/users/edit/{user}', EditUser::class)->name('trov.users.edit');
    Route::get('/profile/{user}', Profile::class)->name('trov.users.profile');
});
