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
        $adapter = Mockery::mock(QcloudAdapter::class, ['secretId', 'secretKey', 'bucket', 'region'])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        return [
            [$adapter],
        ];
    }

    /**
     * @dataProvider qcloudProvider
     * @group testing
     */
    public function testWrite($adapter)
    {
        // \Mockery::mock('stdClass')->expects()->put('token', 'foo/bar.md', 'content', null, 'application/octet-stream')
        //     ->andReturn(['response', false], ['response', true])
        //     ->twice();

        // $this->assertSame('response', $adapter->write('foo/bar.md', 'content', new Config()));
        // $this->assertFalse($adapter->write('foo/bar.md', 'content', new Config()));
    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testWriteStream()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testUpdate()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testUpdateStream()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testRename()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testCopy()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testDelete()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testDeleteDir()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testCreateDir()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testHas()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testRead()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testReadStream()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testListContents()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testGetMetaData()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testGetSize()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
     */
    public function testGetMimeType()
    {

    }

    /**
     * @dataProvider qcloudProvider
     * @todo
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
