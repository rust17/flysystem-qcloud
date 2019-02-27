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
        $config = new Config(['key' => $path, 'body' => $contents]);

        $options = $this->getOptions($config);

        $this->client()->putObject($options);

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
        $config = new Config(['key' => $path, 'body' => $resource]);

        $options = $this->getOptions($config);

        $this->client()->putObject($options);

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
        $config = new Config(['key' => $newpath, 'copySource' => "{$this->bucket}.cos.{$this->region}.myqcloud.com/{$path}"]);

        $options = $this->getOptions($config);

        $this->client()->copyObject($options);

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
        $config = new Config(['key' => $path]);

        $options = $this->getOptions($config);

        try {
            $result = $this->client()->deleteObject($options);
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
        $config = new Config(['key' => $path]);

        $options = $this->getOptions($config);

        try {
            $result = $this->client()->headObject($options);
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
        $config = new Config(['key' => $path]);

        $options = $this->getOptions($config);

        $object = $this->client()->getObject($options);

        $contentType = $object->get('ContentType');
        $lastModified = $object->get('LastModified');
        $contentLength = $object->get('ContentLength');
        $meta = $object->get('MissingMeta');
        $contents = $object->get('Body')->__toString();

        return compact('contents', 'path', 'meta', 'contentLength', 'lastModified', 'contentType');
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
        $config = new Config(['directory' => $directory]);

        $options = $this->getOptions($config);

        $object = $this->client()->listObjects($options);

        $contents = $object->get('Contents');
        array_walk($contents, function (&$_content) {
            $_content['path'] = $_content['Key'];
        });

        return $contents;
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
        $mimetype = $result['contentType'];
        return compact("mimetype");
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
        $timestamp = $result['lastModified'];
        return compact("timestamp");
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
     * Get the setting config
     *
     * @param Config $config
     *
     * @return array
     */
    public function getOptions(Config $config)
    {
        $bucket     = $this->getBucket();

        $key        = $config->get('key');

        $body       = $config->get('body');

        $copySource = $config->get('copySource');

        $directory  = $config->get('directory');

        return array_filter(['Bucket' => $bucket, 'Key' => $key, 'Body' => $body, 'CopySource' => $copySource, 'Prefix' => $directory]);
    }
}
