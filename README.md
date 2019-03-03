<h1 align="center"> qcloud filesystem </h1>

<p align="center"> Flysystem adaptet for the qcloud storage.</p>


## Installing

```shell
$ composer require circle33/flysystem-qcloud -vvv
```

## Usage

```php
use League\Flysystem\Filesystem;
use Circle33\Flysystem\Qcloud\QcloudAdapter;

$secretId  = 'xxxxxx';
$secretKey = 'xxxxxx';
$bucket    = 'xxxxxx';
$region    = 'xxxxxx';

$adapter = new QcloudAdapter($secretId, $secretKey, $bucket, $region);

$filesystem = new League\Flysystem\Filesystem($adapter);
```

Use in laravel

```shell
composer require circle33/flysystem-qcloud -vvv
```

Add config to your fliesystems.php
```php
'disks' => [
    ...
    'qcloud_oss' => [
        'driver'    => 'qcloud_oss',
        'region'    => env('QCLOUDREGION', ''),
        'secretId'  => env('QCLOUDSECRETID', ''),
        'secretKey' => env('QCLOUDSECRETKEY', ''),
        'bucket'    => env('QCLOUDBUCKET', ''),
    ],
    ...
],

$filesystem = Storage::disk('qcloud_oss');
```

It exposes a user interface allowing you to manage your files.If you want to add to your project，you need to:

```shell
php artisan vendor:publish --provider=Circle33\\Flysystem\\Qcloud\\QcloudServiceProvider
```

```shell
php artisan migrate
```

Navigate to http://your-project.test/circle33qcloud (update `circle33qcloud` to match the `circle33_qcloud.ui_url` configuration setting) and use the interface to manage your files.

### API

```php
$filesystem->write('file.md', 'contents');

$filesystem->writeStream('file.md', fopen('path/to/your/local/file.jpg', 'rb'));

$filesystem->update('file.md', 'new contents');

$filesystem->updateStream('file.md', fopen('path/to/your/local/file.jpg', 'rb'));

$filesystem->rename('foo.md', 'foo2.md');

$filesystem->copy('foo.md', 'foo2.md');

$filesystem->delete('file.md');

$filesystem->has('file.md');

$filesystem->read('file.md');

$filesystem->listContents('your qcloud oss filelist path');

$filesystem->getMetadata('file.md');

$filesystem->getSize('file.md');

$filesystem->getMimetype('file.md');

$filesystem->getTimestamp('file.md');
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/rust17/flysystem-qcloud/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/rust17/flysystem-qcloud/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## reference

- [overtrue/flysystem-qiniu](https://github.com/overtrue/flysystem-qiniu)
- [joedixon/laravel-translation](https://github.com/joedixon/laravel-translation)

## License

MIT
