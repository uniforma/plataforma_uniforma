<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubmissaoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [DemandController::class, 'index'])->name('home');
Route::get('/submissoes/{submissao}', [DemandController::class, 'show'])->name('demands.show');
Route::redirect('/user/vitrineSub', '/')->name('user.vitrine');

Route::group(['middleware' => ['auth:user'], 'prefix' => 'user'], function () {
    Route::get('/submissions', [DemandController::class, 'mine'])->name('user.submissions.index');
    Route::get('/submissions/create', [DemandController::class, 'create'])->name('user.submissions.create');
    Route::get('/submissions/submission-panel', [DemandController::class, 'showSub'])->name('user.submissions.showSub');
    Route::post('/submissions/create', [DemandController::class, 'store'])->name('user.submissions.store');
    Route::post('/submissions/{submission}/support', [DemandController::class, 'support'])->name('user.submissions.support');
    Route::delete('/submissions/{submission}/support', [DemandController::class, 'removeSupport'])->name('user.submissions.support.destroy');
    Route::post('/submissions/{submission}/teaching-interest', [DemandController::class, 'teachingInterest'])->name('user.submissions.teaching-interest');
    Route::delete('/submissions/{submission}/teaching-interest', [DemandController::class, 'removeTeachingInterest'])->name('user.submissions.teaching-interest.destroy');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
});

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');

    Route::resource('admins', AdminController::class);

    Route::patch('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
    Route::resource('users', UserController::class);

    Route::patch('submissions/{submission}/restore', [SubmissaoController::class, 'restore'])->name('submissions.restore');
    Route::delete('submissions/{submission}/force-delete', [SubmissaoController::class, 'forceDelete'])->name('submissions.force-delete');
    Route::resource('submissions', SubmissaoController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class)->only(['index', 'show']);

    Route::resource('logs', LogController::class)->only(['index', 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});
