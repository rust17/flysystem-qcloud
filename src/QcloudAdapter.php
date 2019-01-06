<?php

namespace Circle33\Flysystem\Qcloud;

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

        $arr = ['Bucket' => $bucket ?: $this->bucket, 'Key' => $path, 'Body' => $resource];

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

        $this->delete($path);

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
        $arr = ['Bucket' => $this->bucket, 'CopySource' => "{$this->bucket}.cos.{$this->region}.myqcloud.com/{$path}", 'Key' => $newpath];

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

        try {
            $result = $this->client()->deleteObject($arr);
            return is_object($result);
        } catch (\Exception $e) {
            return false;
        }
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
        $arr = ['Bucket' => $this->bucket, 'Key' => $path];

        try {
            $result = $this->client()->headObject($arr);
            return is_object($result);
        } catch (\Exception $e) {
            return false;
        }
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
        $object = $this->client()->getObject([
            'Bucket' => $this->bucket,
            'Key' => $path,
        ]);
        $contentLength = $object->get('ContentLength');
        $meta = $object->get('MissingMeta');
        $contents = $object->get('Body')->__toString();

        return compact('contents', 'path', 'meta', 'contentLength');
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
        if (ini_get('allow_url_fopen')) {
            $stream = fopen('https://' . $this->bucket. '.cos.' . $this->region . '.myqcloud.com/' . $path, 'r');

            return compact("stream", "path");
        }

        return false;
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
        $object = $this->client()->listObjects([
            'Bucket' => $this->bucket,
            'Prefix' => $directory
        ]);

        return $object->get('Contents');
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
        $size = $result['contentLength'];
        return compact("size");
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
}