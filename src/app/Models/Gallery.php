<?php

namespace SeanDowney\BackpackGalleryCrud\app\Models;

use Storage;
use Log;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Gallery extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'galleries';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = [
        'title', 'slug', 'body', 'images', 'captions', 'status',
    ];
    protected $casts = [
        'images' => 'array',
        'captions' => 'array',
    ];


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Return the URL to the post.
     *
     * @return string
     */
    public function url()
    {
        return route('view-gallery', $this->slug);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }



    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setCaptionsAttribute($captions)
    {
        $captions = !is_array($captions) ? [] : $captions;
        $images = json_decode($this->attributes['images'], true);
        $images = !is_array($images) ? [] : $images;

        $captionsOrder = [];

        foreach ($images as $file_path) {
            $captionsOrder[$file_path] = !array_key_exists($file_path, $captions) ? '' : $captions[$file_path];
        }

        $this->attributes['captions'] = json_encode($captionsOrder);
    }

}
