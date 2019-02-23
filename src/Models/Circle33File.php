<?php

namespace Circle33\Flysystem\Qcloud\Models;

use Illuminate\Database\Eloquent\Model;

class Circle33File extends Model
{
    protected $table = 'circle33files';

    protected $fillable = [
        'filename', 'size', 'path', 'mime', 'url'
    ];
}
