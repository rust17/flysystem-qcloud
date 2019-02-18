<?php

namespace Circle33\Flysystem\Qcloud\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public static function collection($resource)
    {
        $resource->loadMissing(self::getRequestIncludes());

        return parent::collection($resource);
    }
}
