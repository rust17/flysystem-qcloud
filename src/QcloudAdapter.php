<?php

namespace Circle33\Flysystem\Qcloud;

require __DIR__.'/../vendor/autoload.php';

use League\Flysystem\Config;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Adapter\Polyfill\NotSupportingVisibilityTrait;
use Qcloud\Cos\Client;

class QcloudAdapter extends AbstractAdapter
{
    use NotSupportingVisibilityTrait;

    /**
     * @var \Qcloud\Cos\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $secretId;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $bucket;

    /**
     * @var string
     */
    protected $region;

    /**
     * QcloudAdapter constructor
     * @param string $region
     * @param string $secretId
     * @param string $secretKey
     */
    public function __construct($secretId, $secretKey, $bucket, $region)
    {
        $this->region    = $region;
        $this->secretId  = $secretId;
        $this->secretKey = $secretKey;
        $this->bucket    = $bucket;
    }

    /**
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function write($path, $contents, Config $config)
    {
        if ($config->has('bucket')) {
            $bucket = $config->get('bucket');
        }

        $arr = ['Bucket' => $bucket ?: $this->bucket, 'Key' => $path, 'Body' => $contents];

        $this->client()->putObject($arr);

        return true;
    }

    /**
     * Get a new client.
     *
     * @return \Qcloud\Cos\Client
     */
    public function client()
    {
        return $this->client ?: $this->client = new Client([
            'region'      => $this->region,
            'credentials' => [
                'secretId'  => $this->secretId,
                'secretKey' => $this->secretKey,
            ],
        ]);
    }

    /**
     * Write a new file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function writeStream($path, $resource, Config $config)
    {
        if ($config->has('bucket')) {
            $bucket = $config->get('bucket');
        }

        $arr = ['Bucket' => $bucket ?: $this->bucket, 'Key' => $path, 'Body' => fopen($resource, 'rb')];

        $this->client()->putObject($arr);

        return true;
    }

    /**
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function update($path, $contents, Config $config)
    {
        if ($config->has('bucket')) {
            $bucket = $config->get('bucket');
        }

        $this->delete($bucket, $path);

        $this->write($path, $contents, $config);

        return true;
    }

    /**
     * Update a file using a stream.
     *
     * @param string   $path
     * @param resource $resource
     * @param Config   $config   Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function updateStream($path, $resource, Config $config)
    {
        if ($config->has('bucket')) {
            $bucket = $config->get('bucket');
        }

        $this->delete($bucket, $path);

        $this->writeStream($path, $resource, $config);

        return true;
    }

    /**
     * Rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function rename($path, $newpath)
    {
        $this->copy($path, $newpath);

        $this->delete($this->bucket, $path);

        return true;
    }

    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {
        $arr = ['Bucket' => $this->bucket, 'CopySource' => '{$this->bucket}.cos.{$this->region}.myqcloud.com/{$path}', 'Key' => $newpath];

        $this->client()->copyObject($arr);

        return true;
    }

    /**
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path)
    {
        $arr = ['Bucket' => $this->bucket, 'Key' => $path];

        $this->client()->deleteObject($arr);
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname)
    {
        return true;
    }

    /**
     * Create a directory.
     *
     * @param string $dirname directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config)
    {
        return ['path' => $dirname, 'type' => 'dir'];
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        $res = $this->client()->headObject([
            'Bucket' => $this->bucket,
            'Key' => $path,
        ]);

        return is_array($res);
    }

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path)
    {
        return $this->client()->headObject([
            'Bucket' => $this->bucket,
            'Key' => $path,
        ]);
    }

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path)
    {
        $result = $this->client()->getObject([
            'Bucket' => $this->bucket,
            'Key' => $path
        ]);

        return $result['Body'];
    }

    /**
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool   $recursive
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false)
    {
        $result = $this->client()->listObjects([
            'Bucket' => $this->bucket,
            'Prefix' => $directory
        ]);

        return $result;
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {
        $result = $this->read($path);

        return $result['MissingMeta'];
    }

    /**
     * Get the size of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path)
    {
        $result = $this->read($path);

        return $result['ContentLength'];
    }

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {
        $result = $this->read($path);

        return $result;
    }

    /**
     * Get the last modified time of a file as a timestamp.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {
        $result = $this->read($path);

        return $result['LastModified'];
    }
}

// $Qcloud = new QcloudAdapter();
// $config = new Config([
//             'region' => 'sdfsa',
//             'credentials' => [
//                 'secretId' => 'sdfsdf',
//                 'secretKey' => 'sdff',
//             ],
//         ]);
// print_r($config->get('region'));die;
// $Qcloud->write('asdf', 'asdfs', $config);