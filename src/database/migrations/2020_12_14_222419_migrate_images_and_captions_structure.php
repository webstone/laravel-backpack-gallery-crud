<?php

use SeanDowney\BackpackGalleryCrud\app\Models\Gallery;
use Illuminate\Database\Migrations\Migration;

class MigrateImagesAndCaptionsStructure extends Migration
{
    /**
     * Change the images captions structures to suit the new version
     *
     * @return void
     */
    public function up()
    {

        $galleries = Gallery::get();

        foreach($galleries as $gallery) {
            $images   = $gallery->images;
            $captions = $gallery->captions;

            $updatedImages = [];
            $updatedCaptions = [];
            foreach($images as $image) {
                if (!isset($image['image_path'])) {
                    continue;
                }

                $updatedImages[] = 'galleries/'.$image['image_path'];
                $updatedCaptions['galleries/'.$image['image_path']] = $captions[$image['image']];
            }

            if (count($updatedImages)) {
                $gallery->images = $updatedImages;
                $gallery->captions = $updatedCaptions;
                $gallery->save();
            }
        }
    }

    /**
     * Not possible to migrate back
     *
     * @return void
     */
    public function down()
    {
    }
}
