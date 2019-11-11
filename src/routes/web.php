<?php

Route::prefix('install')
    ->name('installer.')
    ->namespace('Codemen\Installer\Controllers')
    ->middleware(['web', 'install'])
    ->group(function () {
        Route::get('{types}', 'ViewController')->name('types');

        Route::post('setup/{types}', 'StoreController')->name('types.store');

        Route::get('/', [
            'as' => 'index',
            'uses' => 'WelcomeController@welcome',
        ]);
    });

