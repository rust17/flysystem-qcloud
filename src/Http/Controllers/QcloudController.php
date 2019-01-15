<?php

namespace Circle33\Flysystem\Qcloud\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QcloudController extends Controller
{
    public function index(Request $request)
    {
        $hello = 'hello world';

        return view('qcloud::qclouds.index', compact('hello'));
    }
}