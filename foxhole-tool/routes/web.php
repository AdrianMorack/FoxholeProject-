<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


//This is routing to all the website tools
Route::get('/', \App\Livewire\HomePage::class)->name('home.page');
Route::get('/war-status', \App\Livewire\WarStatus::class)->name('war.status');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');






Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

});

require __DIR__.'/auth.php';
