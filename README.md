<h1 align="center"> qcloud filesystem </h1>

<p align="center"> A qcloud filesystem package.</p>


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

$flysystem = new League\Flysystem\Filesystem($adapter);
```

### API

TODO

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