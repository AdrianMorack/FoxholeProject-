<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Middleware\SetShardFromRoute;

// Root redirect to default shard
Route::get('/', function () {
    $shard = session('foxhole_shard', 'baker');
    return redirect()->route('home.page', ['shard' => $shard]);
});

// Shard-specific routes
Route::prefix('/{shard}')->where(['shard' => 'able|baker'])->middleware(SetShardFromRoute::class)->group(function () {
    Route::get('/', \App\Livewire\HomePage::class)->name('home.page');
    Route::get('/war-status', \App\Livewire\WarStatus::class)->name('war.status');
    Route::get('/war-maps', \App\Livewire\MapList::class)->name('map.list');
    Route::get('/war-maps/{mapName}', \App\Livewire\MapViewer::class)->name('map-viewer');
});

// Shard switcher - redirects to the other shard's current page
Route::post('/shard/toggle', function (Illuminate\Http\Request $request) {
    $current = session('foxhole_shard', 'baker');
    $new = $current === 'able' ? 'baker' : 'able';
    session(['foxhole_shard' => $new]);
    
    // Get the referring URL and swap the shard
    $referer = $request->header('referer', url('/'));
    $path = parse_url($referer, PHP_URL_PATH);
    
    // Replace the shard in the path
    if (preg_match('#^/(' . $current . ')(/.*)?$#', $path, $matches)) {
        $newPath = '/' . $new . ($matches[2] ?? '');
    } else {
        // Fallback to home page with new shard
        $newPath = '/' . $new;
    }
    
    return redirect($newPath);
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
