<?php

Route::prefix('install')
    ->name('installer.')
    ->namespace('Codemen\Installer\Controllers')
    ->middleware(['web', 'install'])
    ->group(function () {
        Route::get('{types}', 'ViewController')
            ->name('types')
            ->where(['types' => implode('|', array_keys(config('installer.routes', [])))]);

        Route::post('setup/{types}', 'StoreController')
            ->name('types.store')
            ->where(['types' => implode('|', array_keys(config('installer.routes', [])))]);

        Route::get('/', [
            'as' => 'index',
            'uses' => 'WelcomeController@welcome',
        ]);
    });

