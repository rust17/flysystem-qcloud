<?php

namespace Circle33\Flysystem\Qcloud\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QcloudController extends Controller
{
    public function __construct()
    {
        $this->storage = Storage::disk('qcloud_oss');
    }

    public function index(Request $request)
    {
        $hello = 'hello world';

        return view('qcloud::qcloud.index', compact('hello'));
    }

    public function listContents(Request $request)
    {
        return $this->storage->listContents('/', false);
    }

    public function show()
    {
        return view('qcloud::qcloud.show');
    }
}