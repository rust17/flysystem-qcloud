<?php

use Circle33\Flysystem\Qcloud\Http\Controllers\QcloudController;

Route::group(['middleware' => 'web'] + ['namespace' => 'Circle33\\Flysystem\\Qcloud\\Http\\Controllers'], function ($router) {
    $router->get('qcloud', 'QcloudController@index')
        ->name('qclouds.index');
});