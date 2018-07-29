<?php

if (! function_exists('gallery_image_url')) {
    /**
     * Return the url of the image for the gallery using Glide
     *
     * @param  string  $image_path
     * @return string
     */
    function gallery_image_url($image_path)
    {
        $glide_path = config('seandowney.gallerycrud.glide_path');
        $disk = config('seandowney.gallerycrud.disk');

        return url($glide_path.'/'.$disk.'/'.$image_path);
    }
}


if (! function_exists('image_url')) {
    /**
     * Return the url of the image for an imaged saved as a "browse" type using Glide
     *
     * @param  string  $image_path
     * @return string
     */
    function image_url($image_path)
    {
        $glide_path = config('seandowney.gallerycrud.glide_path');

        return url($glide_path.'/'.$image_path);
    }
}

