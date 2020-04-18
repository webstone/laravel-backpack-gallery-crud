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

// Glide path

Route::get('/'.config('seandowney.gallerycrud.glide_path', 'images').'/{path}', 'SeanDowney\BackpackGalleryCrud\app\Http\Controllers\ImageController@show')->where('path', '.+');

// Admin
Route::group([
    'namespace' => 'SeanDowney\BackpackGalleryCrud\app\Http\Controllers\Admin',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'admin'],
], function () {
    Route::crud('gallery', 'GalleryCrudController');
    //CRUD::resource('gallery', 'GalleryCrudController');
});
