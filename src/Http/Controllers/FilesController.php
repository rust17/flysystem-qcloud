<?php

namespace Circle33\Flysystem\Qcloud\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Circle33\Flysystem\Qcloud\Models\File;
use Circle33\Flysystem\Qcloud\Http\Resources\FileResource;

class FilesController extends ApiController
{
    public function __construct()
    {
        $this->storage = Storage::disk('qcloud_oss');
    }

    public function index(Request $request)
    {
        if ($directory = $request->get('directory')) {
            $files = File::query()->where('path', $directory)->paginate();
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
        if ($filename = $request->get('filename')) {
            $file = File::query()->where('filename', $filename)->get();
            return FileResource::toArray($file);
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

        $file = File::create([
            'filename' => $request->get('path'),
            ''
        ]);

        return response()->json([
            'message' => '文件存储成功！'
        ]);
    }

    public function rename(File $file, Request $request)
    {
        if (File::query()->find($file->id)) {
            $newFilename = $request->get('newFilename');
            $file->update(['filename' => $newFilename]);
            $this->storage->rename($file->filename, $newFilename);
        }

        \abort(404);
    }

    public function destroy(File $file)
    {
        if (File::query()->find($file->id)) {
            $file->delete();
            $this->storage->delete($file->filename);
        }

        \abort(404);
    }

    public function copy(File $file, Request $request)
    {
        if (File::query()->find($file->id)) {
            $newFilename = $request->get('newFilename');
            $newFile = File::create([
                'filename' => $newFilename,
                'size'     => $file->size,
                'path'     => $file->path,
                'mime'     => $file->mime,
                'url'      => ''
            ]);
            $this->storage->copy($file->filename, $newFilename);
        }

        \abort(404);
    }
}
