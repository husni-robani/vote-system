<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
//contoh perkiraan route election
//Route::get('election/{name}/{token}', function (){
//
//})->middleware(['election.active', 'verified.election.link']);


Route::get('/election/email/{name}', function (){
   return 'test';
})->middleware('election.active');

Route::middleware('election.active')->group(function () {
   Route::get('election/{title}/requestLink', [\App\Http\Controllers\VoteController::class, 'requestLink'])->name('election.requestLink');
   Route::post('election/{title}/sendLink', [\App\Http\Controllers\VoteController::class, 'storeEmail'])->name('election.storeEmail');
   Route::get('election/{title}/{token}', [\App\Http\Controllers\VoteController::class, 'create'])->name('election');
   Route::post('election/{title}/{token}', [\App\Http\Controllers\VoteController::class, 'store'])->name('election.store');
});

Route::get('/test', function (){
    $election = \App\Models\Election::with('generations.voters')->get();
    dd($election[0]->generations->all);
});

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
