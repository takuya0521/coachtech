<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| お問い合わせ（PG01〜PG03）
|--------------------------------------------------------------------------
*/
Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/thanks', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| 管理画面（PG04〜PG07）
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
    Route::get('/reset', [AdminController::class, 'reset'])->name('admin.reset');
    Route::delete('/delete', [AdminController::class, 'delete'])->name('admin.delete');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
});

/*
|--------------------------------------------------------------------------
| ログアウト（Fortify）
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
