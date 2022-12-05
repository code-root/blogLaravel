<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'blog', 'middleware' => ['auth']], function () {
    
    Route::get('post', [PostController::class, 'index']);
    Route::get('post/{postId}', [PostController::class, 'postId']);
    Route::get('add-post', [PostController::class, 'show']);
    Route::post('add-post-blog', [PostController::class, 'cerate'])->name('add-post-blog');

    Route::post('add-comment', [PostController::class, 'comment_add'])->name('add-comment');
    Route::post('delete-post', [PostController::class, 'delete_post'])->name('delete-post');
    Route::post('delete-comment', [PostController::class, 'delete_comment'])->name('delete-comment');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
