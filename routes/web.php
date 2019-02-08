<?php

use Circle33\Flysystem\Qcloud\Http\Controllers\QcloudController;

Route::group(['middleware' => 'web'] + ['namespace' => 'Circle33\\Flysystem\\Qcloud\\Http\\Controllers'], function ($router) {
    $router->get(config('qcloud.ui_url'), 'QcloudController@index')
        ->name('qcloud.index');
    $router->get(config('qcloud.ui_url') . '/list_contents/{path}', 'QcloudController@listContents')
        ->name('qcloud.files');
    $router->get(config('qcloud.ui_url') . '/file/{file}', 'QcloudController@show')->name('qcloud.file.show');
});