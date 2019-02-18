<?php

namespace Circle33\Flysystem\Qcloud\Http\Resources;

class FileResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'filename'     => $request->filename,
            'size'         => $request->size,
            'lastModified' => $request->lastModified,
            'extension'    => $request->extension,
            'id'           => $request->id,
        ];
    }
}
