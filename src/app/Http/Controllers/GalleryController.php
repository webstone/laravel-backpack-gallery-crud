<?php

namespace SeanDowney\BackpackGalleryCrud\app\Http\Controllers;

use App\Http\Controllers\Controller;
use SeanDowney\BackpackGalleryCrud\app\Models\Gallery;
use Storage;

/**
 * Base Controller for the frontend
 */
class GalleryController extends Controller
{
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

        $files_data = [];
        if (isset($gallery->images) && !empty($gallery->images)) {
            foreach ($gallery->images as $file) {
                $size_data = getimagesize(storage_path('app/'.$file));

                $files_data[] = [
                    'image_path' => $file,
                    'width' => $size_data[0],
                    'height' => $size_data[1],
                    'caption' => isset($gallery->captions[$file]) ? $gallery->captions[$file] : '',
                ];
            }
        }

        $this->data['title']   = $gallery->title;
        $this->data['gallery'] = $gallery->withFakes();
        $this->data['files']   = $files_data;

        return view('seandowney::gallerycrud.gallery', $this->data);
    }

}
