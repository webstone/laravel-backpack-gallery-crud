<?php

namespace SeanDowney\BackpackGalleryCrud\app\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
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
        'image_items' => 'array',
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


    public function getImageItemsAttribute()
    {
        $disk = config('seandowney.gallerycrud.disk');
        $files = Storage::disk($disk)->files($this->slug);

        $image_items = [];
        foreach ($files as $file_path) {
            $file = str_replace($this->slug.'/', '', $file_path);
            $size_data = getimagesize(public_path($disk.'/'.$file_path));
            $image_items[] = [
                'image' => $file,
                'image_path' => $disk.'/'.$file_path,
                'thumbnail_path' => $disk.'/thumbnails/'.$file_path,
                'live' => isset($this->images[$file]) ? $this->images[$file]['live'] : 0,
                'width' => $size_data[0],
                'height' => $size_data[1],
                'caption' => isset($this->captions[$file]) ? $this->captions[$file] : '',
            ];
        }

        return $image_items;
    }

	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
    public function setImagesAttribute($value)
    {
        $disk = config('seandowney.gallerycrud.disk');
        $attribute_name = "images";

        $files = Storage::disk($disk)->allFiles($this->slug);
        $image_items = [];
        foreach ($files as $key => $file_path) {
            $file = str_replace($this->slug.'/', '', $file_path);
            $size_data = getimagesize(public_path($disk.'/'.$file_path));
            $image_items[$file] = [
                'image' => $file,
                'image_path' => $disk.'/'.$file_path,
                'thumbnail_path' => $disk.'/thumbnails/'.$file_path,
                'live' => isset($value[$file]) ? $value[$file] : 0,
                'width' => $size_data[0],
                'height' => $size_data[1],
            ];
        }

        $this->attributes[$attribute_name] = json_encode($image_items);
    }

}
