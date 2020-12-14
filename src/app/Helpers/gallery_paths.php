<?php

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

