<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');

    Route::livewire('categories', 'pages::category.index')->name('categories.index');
    Route::livewire('story-points', 'pages::story-point.index')->name('story-points.index');
    Route::livewire('estimated-hours', 'pages::estimated-hour.index')->name('estimated-hours.index');
    Route::livewire('tasks', 'pages::task.index')->name('tasks.index');
    Route::livewire('tasks/{project}', 'pages::task.detail')->name('tasks.detail');
    Route::livewire('reports', 'pages::report')->name('reports');
    Route::livewire('documentation', 'pages::documentation')->name('documentation');
});

require __DIR__.'/settings.php';
