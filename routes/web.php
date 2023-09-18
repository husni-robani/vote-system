<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\GenerationController;
use App\Http\Controllers\Admin\VoteLinkController;
use App\Http\Controllers\Admin\VoterController;
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


Route::get('/election/email/{name}', function (){
   return 'test';
})->middleware('election.active');

Route::middleware('election.active')->group(function () {
   Route::get('election/{id}/requestLink', [\App\Http\Controllers\VoteController::class, 'requestLink'])->name('election.requestLink');
   Route::post('election/{id}/sendLink', [\App\Http\Controllers\VoteController::class, 'storeEmail'])->name('election.storeEmail');
   Route::get('election/{id}/{token}', [\App\Http\Controllers\VoteController::class, 'create'])->name('election');
   Route::post('election/{id}/{token}', [\App\Http\Controllers\VoteController::class, 'store'])->name('election.store');
   Route::post('election/{id}/{token}/first-step', [\App\Http\Controllers\VoteController::class, 'firstStep'])->name('election.first-step');
});
Route::get('/result/{id}', [\App\Http\Controllers\VoteController::class, 'result'])->name('election.result');
Route::get('/', [\App\Http\Controllers\VoteController::class, 'index'])->name('election.menu');

Route::get('/test', function (){
   return Inertia::render('Election/Finish');
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
Route::get('/admin/mainMenu', function(){
    return Inertia::render('Admin/Menu');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/menu', [\App\Http\Controllers\Admin\AdminController::class, 'menu'])->name('admin.menu');
    Route::middleware('election.available')->group(function (){
        Route::controller(ElectionController::class)->group(function () {
            Route::get('admin/vote-system/create/test/{id}', 'create')->name('admin.vote-system.create');
            Route::post('admin/vote-system/store/{id}', 'store')->name('admin.vote-system.store');
            Route::get('admin/vote-system/{id}', 'index')->name('admin.vote-system');
            Route::get('admin/vote-system/switch/{id}', 'switch')->name('admin.vote-system.switch');
            Route::get('admin/vote-System/{id}/edit', 'edit')->name('admin.vote-System.edit');
            Route::patch('admin/vote-system/{id}/update/profile', 'update')->name('admin.vote-system.update.profile');
            Route::delete('admin/vote-system/{id}/delete', 'destroy')->name('admin.vote-system.delete');
        });
        Route::controller(GenerationController::class)->group(function (){
            Route::post('admin/vote-system/{id}/update/gen', 'store')->name('admin.vote-system.update.gen');
            Route::delete('admin/vote-system/{id}/delete/gen', 'destroy')->name('admin.vote-system.delete.gen');
        });
        Route::controller(CandidateController::class)->group(function () {
            Route::get('admin/vote-system/{id}/candidates', 'index')->name('admin.vote-system.candidates');
            Route::get('admin/vote-system/{id}/{candidateId}/edit', 'edit')->name('admin.vote-system.candidate.edit');
            Route::delete('admin/vote-system/{id}', 'destroy')->name('admin.vote-system.candidate.delete');
            Route::post('admin/vote-system/{id}/store', 'store')->name('admin.vote-system.candidate.store');
            Route::patch('admin/vote-system/{id}/{candidateId}/update', 'update')->name('admin.vote-system.candidate.update');
        });
        Route::controller(VoterController::class)->group(function (){
            Route::delete('admin/vote-system/{id}/{voterId}/delete', 'destroy')->name('admin.vote-system.voter.destroy');
            Route::get('admin/vote-system/{id}/voters', 'index')->name('admin.vote-system.voters');
        });
        Route::controller(VoteLinkController::class)->group(function (){
            Route::get('admin/vote-system/{id}/voteLinks', 'index')->name('admin.vote-system.voteLinks');
        });

        Route::get('admin/vote-system')->name('admin.vote-system.random');
    });
});

require __DIR__.'/auth.php';
