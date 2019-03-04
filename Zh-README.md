<h1 align="center"> 腾讯云文件驱动 </h1>

<p align="center"> 腾讯云对象存储文件系统的 flysystem 适配器</p>


## 安装

```shell
$ composer require circle33/flysystem-qcloud -vvv
```

## 使用

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

在 Laravel 当中使用

```shell
composer require circle33/flysystem-qcloud -vvv
```

添加如下代码到你的 fliesystems.php 文件
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

该扩展包自带了一个用户界面，你可以使用该界面管理你的文件。如果你想要整合到你的项目中，需要执行：

```shell
php artisan vendor:publish --provider=Circle33\\Flysystem\\Qcloud\\QcloudServiceProvider
```

```shell
php artisan migrate
```

访问链接 http://your-project.test/circle33qcloud （可以将 `circle33qcloud` 更改成 `circle33_qcloud.php` 配置文件中的 `ui_url` 键对应的值），然后就可以使用该界面了。

### 接口

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

## 贡献

你可以通过以下三种方式帮助完善该扩展包：

1. 使用 [issue tracker](https://github.com/rust17/flysystem-qcloud/issues) 提交 bug 报告。
2. 使用 [issues tracker](https://github.com/rust17/flysystem-qcloud/issues) 回答问题以及修复 bug。
3. 提交新功能或者更新 wiki。

_该扩展包的代码贡献机制还不是很正式。你只需要确保你的代码遵循 PSR-0，PSR-1 以及 PSR-2 代码规范即可。提交代码之前请先确保通过单元测试。_

## 参考

- [overtrue/flysystem-qiniu](https://github.com/overtrue/flysystem-qiniu)
- [joedixon/laravel-translation](https://github.com/joedixon/laravel-translation)

## License

MIT
