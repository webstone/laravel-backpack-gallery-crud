<?php

namespace SeanDowney\BackpackGalleryCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Storage;

// VALIDATION: change the requests to match your own file names if you need form validation
use SeanDowney\BackpackGalleryCrud\app\Http\Requests\GalleryRequest as StoreRequest;
use SeanDowney\BackpackGalleryCrud\app\Http\Requests\GalleryRequest as UpdateRequest;

class GalleryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { setupCreateDefaults as traitSetupCreateDefaults; store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("SeanDowney\BackpackGalleryCrud\app\Models\Gallery");
        $this->crud->setRoute(backpack_url('gallery'));
        $this->crud->setEntityNameStrings('gallery', 'galleries');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD FIELDS
        $this->crud->addField([    // TEXT
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
            'placeholder' => 'Your title here',
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your title, if left empty.',
        ]);

        $this->crud->addField([    // WYSIWYG
            'name' => 'body',
            'label' => 'Body',
            'type' => 'ckeditor',
            'placeholder' => 'Your textarea text here',
        ]);

        $this->crud->addField([ // Table
            'name' => 'image_items',
            'label' => 'Images',
            'type' => 'gallery_table',
            'entity_singular' => 'image_item', // used on the "Add X" button
            'columns' => [
                'image' => 'Upload Image',
                'caption' => 'Caption',
            ],
            'max' => 50, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table
            'disk' => config('seandowney.gallerycrud.disk'),
        ]);

        $this->crud->addField([    // SELECT
            'label' => 'Status',
            'type' => 'select_from_array',
            'name' => 'status',
            'allows_null' => true,
            'options' => [0 => 'Draft', 1 => 'Published'],
            'value' => null,
        ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumns(['title']); // add multiple columns, at the end of the stack
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'boolean',
            'options' => [0 => 'Draft', 1 => 'Published'],
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCreateDefaults()
    {
        $this->traitSetupCreateDefaults();

        // ------ HIDDEN FIELDS (for validation / mutators)
        $this->crud->addField([
            'name'  => 'images',
            'type'  => 'hidden',
            'value' => 'null',
        ]);

        $this->crud->addField([
            'name'  => 'captions',
            'type'  => 'hidden',
            'value' => 'null',
        ]);
    }

    public function store(StoreRequest $request)
    {
        $store_response = $this->traitStore($request);

        $disk = config('seandowney.gallerycrud.disk');

        if (!is_dir(Storage::disk($disk)->getAdapter()->getPathPrefix().'/'.$this->crud->entry->slug)) {
            // create the gallery folder
            Storage::disk($disk)->makeDirectory($this->crud->entry->slug);
        }

        return $store_response;
    }

    public function update(UpdateRequest $request)
    {
        return $this->traitUpdate($request);
    }
}
