<?php

/**
 * Front end Routes
 */
Route::group(['prefix' => 'gallery'], function () {
    Route::get('/', ['uses' => '\SeanDowney\BackpackGalleryCrud\app\Http\Controllers\GalleryController@index']);
    Route::get('/{gallery}/{subs?}', ['as' => 'view-gallery', 'uses' => '\SeanDowney\BackpackGalleryCrud\app\Http\Controllers\GalleryController@show'])
        ->where(['gallery' => '^((?!admin).)*$', 'subs' => '.*']);
});

// Glide path
Route::get('/'.config('seandowney.gallerycrud.glide_path', 'images').'/{path}', 'SeanDowney\BackpackGalleryCrud\app\Http\Controllers\ImageController@show')->where('path', '.+');


/**
 * Admin routes
 */
Route::group([
    'namespace' => 'SeanDowney\BackpackGalleryCrud\app\Http\Controllers\Admin',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud('gallery', 'GalleryCrudController');
});

