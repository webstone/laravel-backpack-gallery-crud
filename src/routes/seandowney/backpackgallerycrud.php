<?php

/*
|--------------------------------------------------------------------------
| Backpack\NewsCRUD Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\NewsCRUD package.
|
*/

Route::group([
                'namespace' => 'SeanDowney\BackpackGalleryCrud\app\Http\Controllers\Admin',
                'prefix' => config('backpack.base.route_prefix', 'admin'),
                'middleware' => ['web', 'admin'],
            ], function () {
                CRUD::resource('gallery', 'GalleryCrudController');
            });
