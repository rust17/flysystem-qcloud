<?php

namespace Circle33\Flysystem\Qcloud\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

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
            'filename'     => $this->filename,
            'size'         => $this->size,
            'lastModified' => $this->updated_at->diffForHumans(),
            'extension'    => $this->mime,
            'id'           => $this->id,
        ];
    }
}
