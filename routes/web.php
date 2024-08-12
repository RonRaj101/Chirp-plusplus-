<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\ProfileController;
use App\Models\Chirp;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Helpers\AppHelper;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $allChirps = Chirp::with('user:id,name')->where('privacy_status','publ')->latest()->get();

    //append number of likes and if the authenticated user has liked the chirp
    AppHelper::appendLikes($allChirps);

    return Inertia::render('Dashboard',[
        'chirps' => $allChirps
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    ->only(['index','store','update','destroy'])
    ->middleware(['auth','verified']);

//Get profile information for given id, if same id as authenticated user, redirect to profile.edit    
Route::get('/profiles/{id}', [ProfileController::class, 'show'])->name('profile.show');

Route::resource('likes', LikesController::class)
    ->only(['show','store','destroy'])
    ->middleware(['auth','verified']);

Route::get('/likes', [LikesController::class, 'show'])->name('likes.show');    

require __DIR__.'/auth.php';
