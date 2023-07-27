<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SiteController;

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

Route::get('/', [PostController::class, 'index'])->name('home');
//post by category
Route::get('/category/{category:slug}', [PostController::class, 'byCategory'])->name('by-category');
//about page 
Route::get('/about-us', [SiteController::class, 'about'])->name('about-us');


//innerpage of post

Route::get('/{post:slug}', [PostController::class, 'show'])->name('view');