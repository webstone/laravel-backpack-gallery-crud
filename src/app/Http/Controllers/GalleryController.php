<?php

namespace SeanDowney\BackpackGalleryCrud\app\Http\Controllers;

use SeanDowney\BackpackGalleryCrud\app\Models\Gallery;
use Storage;

/**
 * Base Controller for the frontend
 */
class GalleryController extends Controller
{
    protected $disk;

    public function __construct()
    {
        $this->disk = config('seandowney.gallerycrud.disk');
    }

    /**
     * Gallery listing page
     *
     * @return Response
     */
    public function index()
    {
        $galleries = Gallery::published()->latest()->paginate();

        if (!$galleries) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = 'Galleries';
        $this->data['galleries'] = $galleries;

        return view('seandowney::gallerycrud.index', $this->data);
    }


    /**
     * Display the page for an individual gallery
     *
     * @param  string $slug Slug for the gallery
     *
     * @return Response
     */
    public function show($slug)
    {
        $gallery = Gallery::whereSlug($slug)->published()->first();

        if (!$gallery) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $files = Storage::disk($this->disk)->allFiles($gallery->slug);
        $files_data = [];
        foreach ($files as $file_path) {
            $file = str_replace($gallery->slug.'/', '', $file_path);
            if (!isset($gallery->images[$file]) || ! $gallery->images[$file]['live']) {
                continue;
            }

            $files_data[] = [
                'file' => $file,
                'image_path' => $gallery->images[$file]['image_path'],
                'thumbnail_path' => $gallery->images[$file]['thumbnail_path'],
                'live' => isset($gallery->images[$file]) ? $gallery->images[$file]['live'] : 0,
                'width' => $gallery->images[$file]['width'],
                'height' => $gallery->images[$file]['height'],
                'caption' => isset($gallery->captions[$file]) ? $gallery->captions[$file] : '',
            ];
        }

        $this->data['title']   = $gallery->title;
        $this->data['gallery'] = $gallery->withFakes();
        $this->data['files']   = $files_data;

        return view('seandowney::gallerycrud.gallery', $this->data);
    }

}
