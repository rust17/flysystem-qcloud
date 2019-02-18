<?php

namespace Circle33\Flysystem\Qcloud\Http\Controllers;

use Illuminate\Http\Request;
use Circle33\Flysystem\Qcloud\Models\File;
use Circle33\Flysystem\Qcloud\Http\Resoreces\FileResource;

class FilesController extends ApiController
{
    public function __construct()
    {
        $this->storage = Storage::disk('qcloud_oss');
    }

    public function index(Request $request)
    {
        if ($directory = $request->get('directory')) {
            $files = File::query()->where('path', $directory)->get();
            return FileResource::collection($files);
        }

        \abort(404);
    }

    public function exists(Request $request)
    {
        if ($filename = $request->get('filename')) {
            return ['exists' => File::query()->where('filename', $filename)->exists()];
        }

        \abort(404);
    }

    public function show(Request $request)
    {
        if ($path = $request->read('path')) {
            return [];
        }

        \abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'path' => '',
            'body' => '',
        ]);

        $this->storage->write($request->get('path'), $request->get('body'));

        return response()->json([
            'message' => '文件存储成功！'
        ]);
    }

    public function rename(File $file, Request $request)
    {
        if ($newpath = $request->get('newpath')) {
            $this->storage->rename($file->name, $newpath);
        }

        \abort(404);
    }

    public function destroy()
    {
        return 'hello world';
    }

    public function copy()
    {
        return 'hello world';
    }
}
