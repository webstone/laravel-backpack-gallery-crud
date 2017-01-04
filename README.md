# SeanDowney\BackpackGalleryCrud

[![Latest Version on Packagist][ico-version]](link-packagist)
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

An admin interface to easily add/edit/remove Gallery, using [Laravel Backpack](laravelbackpack.com).

## Install

1) In your terminal:

``` bash
$ composer require seandowney/backpackgallerycrud
```

2) Add the service provider to your config/app.php file:
```php
SeanDowney\BackpackGalleryCrud\GalleryCRUDServiceProvider::class,
```

3) Publish the config file & run the migrations
```bash
$ php artisan vendor:publish --provider="SeanDowney\BackpackGalleryCrud\GalleryCRUDServiceProvider" #publish config, view  and migration files
$ php artisan migrate #create the gallery table
```

4) Configuration of file storage in config/filesystems.php:

```php
'galleries' => [
    'driver' => 'local',
    'root' => public_path('galleries'),
],
```

5) Configuration of file storage in config/elfinder.php:

```php
'roots' => [
    [
        'driver'        => 'GalleryCrudLocalFileSystem',         // driver for accessing file system (REQUIRED)
        'path'          => public_path('galleries'),                 // path to files (REQUIRED)
        'URL'           => url('galleries'), // URL to files (REQUIRED)
        'accessControl' => 'Barryvdh\Elfinder\Elfinder::checkAccess',
        'autoload'      => true,
        'tmbPath'       => 'thumbnails',
        'tmbSize'       => 150,
        'tmbCrop'       => false,
        'tmbBgColor'    => '#000',
    ],
],
```

6) [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/gallery') }}"><i class="fa fa-picture-o"></i> <span>Gallery</span></a></li>
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Testing

``` bash
// TODO
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email sean at considerweb dot com instead of using the issue tracker.

## Credits

- Seán Downey - Lead Developer
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/seandowney/backpackgallerycrud.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/seandowney/backpackgallerycrud.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/seandowney/backpackgallerycrud
[link-downloads]: https://packagist.org/packages/seandowney/backpackgallerycrud
[link-contributors]: ../../contributors
