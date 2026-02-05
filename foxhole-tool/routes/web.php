<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


//This is routing to all the website tools
Route::get('/', \App\Livewire\HomePage::class)->name('home.page');
Route::get('/war-status', \App\Livewire\WarStatus::class)->name('war.status');
Route::get('/war-maps', \App\Livewire\MapList::class)->name('map.list');
Route::get('/war-maps/{mapName}', \App\Livewire\MapViewer::class)->name('map-viewer');

// Shard switcher
Route::post('/shard/toggle', function () {
    $current = session('foxhole_shard', 'baker');
    $new = $current === 'able' ? 'baker' : 'able';
    session(['foxhole_shard' => $new]);
    return redirect()->back();
})->name('shard.toggle');

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
