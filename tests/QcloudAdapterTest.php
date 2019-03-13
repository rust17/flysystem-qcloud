<?php

namespace Circle33\Flysystem\Qcloud\Tests;

use League\Flysystem\Config;
use Mockery;
use Circle33\Flysystem\Qcloud\QcloudAdapter;
use PHPUnit\Framework\TestCase;

/**
 * Class QcloudAdapterTest
 */
class QcloudAdapterTest extends TestCase
{
    public function qcloudProvider()
    {
<<<<<<< HEAD
        $adapter = \Mockery::mock(QcloudAdapter::class, ['secretId', 'secretKey', 'bucket', 'region'])
=======
        $adapter = Mockery::mock(QcloudAdapter::class, ['secretId', 'secretKey', 'bucket', 'region'])
>>>>>>> debug unit test
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        return [
            [$adapter],
        ];
    }

    /**
     * @dataProvider qcloudProvider
<<<<<<< HEAD
     */
    public function testWrite()
=======
     * @group testing
     */
    public function testWrite($adapter)
>>>>>>> debug unit test
    {
        // \Mockery::mock('stdClass')->expects()->put('token', 'foo/bar.md', 'content', null, 'application/octet-stream')
        //     ->andReturn(['response', false], ['response', true])
        //     ->twice();

        // $this->assertSame('response', $adapter->write('foo/bar.md', 'content', new Config()));
        // $this->assertFalse($adapter->write('foo/bar.md', 'content', new Config()));
    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testWriteStream()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testUpdate()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testUpdateStream()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testRename()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testCopy()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testDelete()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testDeleteDir()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testCreateDir()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testHas()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testRead()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testReadStream()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testListContents()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testGetMetaData()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testGetSize()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testGetMimeType()
    {

    }

    /**
<<<<<<< HEAD
     * @dataProvider qcloudProvider
=======
     * @todo
>>>>>>> debug unit test
     */
    public function testGetTimestamp()
    {

    }

    /**
     * @todo
     */
    public function testGetOptions()
    {

    }
}
