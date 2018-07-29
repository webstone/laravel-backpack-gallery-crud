<?php

namespace SeanDowney\BackpackGalleryCrud\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function show(Filesystem $filesystem, $path)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            // 'source' => $filesystem->getDriver(),
            'source' => app('filesystem')->disk('local')->getDriver(),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'image',
        ]);

        return $server->getImageResponse($path, request()->all());
    }
}