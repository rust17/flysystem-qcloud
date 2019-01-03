<?php

namespace Circle33\Flysystem\Qcloud;

require __DIR__.'/../vendor/autoload.php';

use League\Flysystem\Config;
use League\Flysystem\Adapter\AbstractAdapter;
use Qcloud\Cos\Client;

class QcloudAdapter extends AbstractAdapter
{

    /**
     * @var \Qcloud\Cos\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $secrectId;

    /**
     * @var string
     */
    protected $secrectKey;

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
     * @param string $secrectId
     * @param string $secrectKey
     */
    public function __construct($secrectId, $secrectKey, $bucket, $region)
    {
        $this->region     = $region;
        $this->secrectId  = $secrectId;
        $this->secrectKey = $secrectKey;
        $this->bucket     = $bucket;
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
                'secrectId'  => $this->secrectId,
                'secrectKey' => $this->secrectKey,
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
    {}

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
    {}

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
    {}

    /**
     * Rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function rename($path, $newpath)
    {}

    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {}

    /**
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path)
    {}

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname)
    {}

    /**
     * Create a directory.
     *
     * @param string $dirname directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config)
    {}

    /**
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility)
    {}

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {}

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path)
    {}

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path)
    {}

    /**
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool   $recursive
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false)
    {}

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {}

    /**
     * Get the size of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path)
    {}

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {}

    /**
     * Get the last modified time of a file as a timestamp.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {}

    /**
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getVisibility($path)
    {}
}

// $Qcloud = new QcloudAdapter();
// $config = new Config([
//             'region' => 'sdfsa',
//             'credentials' => [
//                 'secrectId' => 'sdfsdf',
//                 'secrectKey' => 'sdff',
//             ],
//         ]);
// print_r($config->get('region'));die;
// $Qcloud->write('asdf', 'asdfs', $config);