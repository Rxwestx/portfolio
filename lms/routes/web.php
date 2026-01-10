<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\TimeLogsController;

Route::get('/', function () {
    return view('welcome');
});

// ダッシュボードはTimeLogsControllerのindexを使う
Route::get('/dashboard', [TimeLogsController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // 目標設定
    Route::get('/goals/create', [GoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');

    // マイページ（詳細ページ兼管理画面）
    Route::get('/timelogs', [TimeLogsController::class, 'index'])->name('timelogs.index');

    // 記録投稿
    Route::get('/timelogs/create', [TimeLogsController::class, 'create'])->name('timelogs.create');
    Route::post('/timelogs', [TimeLogsController::class, 'store'])->name('timelogs.store');

    // 個別記録表示・編集・削除
    Route::get('/timelogs/{timelogs}', [TimeLogsController::class, 'show'])->name('timelogs.show');
    Route::get('/timelogs/{timelogs}/edit', [TimeLogsController::class, 'edit'])->name('timelogs.edit');
    Route::put('/timelogs/{timelogs}', [TimeLogsController::class, 'update'])->name('timelogs.update');
    Route::delete('/timelogs/{timelogs}', [TimeLogsController::class, 'destroy'])->name('timelogs.destroy');

    // プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
