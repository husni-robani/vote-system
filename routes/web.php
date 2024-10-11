<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\ElectionController;
use App\Http\Controllers\Admin\GenerationController;
use App\Http\Controllers\Admin\VoteLinkController;
use App\Http\Controllers\Admin\VoterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('election.active')->group(function () {
   Route::get('election/{id}/requestLink', [\App\Http\Controllers\VoteController::class, 'requestLink'])->name('election.requestLink');
   Route::post('election/{id}/sendLink', [\App\Http\Controllers\VoteController::class, 'storeEmail'])->name('election.storeEmail');
   Route::get('election/{id}/{token}', [\App\Http\Controllers\VoteController::class, 'create'])->name('election');
   Route::post('election/{id}/{token}/first-step', [\App\Http\Controllers\VoteController::class, 'firstStep'])->name('election.first-step');
   Route::post('election/{id}/{token}', [\App\Http\Controllers\VoteController::class, 'store'])->name('election.store');
});
Route::get('/result/{id}', [\App\Http\Controllers\ResultLinkController::class, 'index'])->name('election.result');
Route::get('/', [\App\Http\Controllers\VoteController::class, 'index'])->name('election.menu')
    ->middleware('track.new.ip');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/admin/mainMenu', function(){
    return Inertia::render('Admin/Menu');
});

Route::middleware('auth')->group(function () {
    Route::middleware('election.available')->group(function (){
        Route::controller(ElectionController::class)->group(function () {
            Route::get('admin/vote-system/{id}', 'index')->name('admin.vote-system');
            Route::get('admin/vote-system/create/{id}', 'create')->name('admin.vote-system.create');
            Route::post('admin/vote-system/create/{id}', 'store')->name('admin.vote-system.store');
            Route::get('admin/vote-system/switch/{id}', 'switch')->name('admin.vote-system.switch');
            Route::get('admin/vote-System/{id}/edit', 'edit')->name('admin.vote-System.edit');
            Route::patch('admin/vote-system/{id}/update', 'update')->name('admin.vote-system.update.profile');
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
