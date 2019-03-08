<?php

namespace Circle33\Flysystem\Qcloud\Tests;

use League\Flysystem\Config;
use Mockery;
use Circle33\Flysystem\Qcloud\QcloudAdapter;
use PHPUnit\Framework\TestCase;


class QcloudAdapterTest extends TestCase
{
    public function qcloudProvider()
    {
        $adapter = \Mockery::mock(QcloudAdapter::class, ['secretId', 'secretKey', 'bucket', 'region'])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        return [
            [$adapter],
        ];
    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testWrite()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testWriteStream()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testUpdate()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testUpdateStream()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testRename()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testCopy()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testDelete()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testDeleteDir()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testCreateDir()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testHas()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testRead()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testReadStream()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testListContents()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testGetMetaData()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testGetSize()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testGetMimeType()
    {

    }

    /**
     * @dataProvider qcloudProvider
     */
    public function testGetTimestamp()
    {

    }

    public function testGetOptions()
    {

    }
}
