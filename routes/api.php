<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Access-Control-Allow-Headers, X-Requested-With');
header('Access-Control-Allow-Methods: *');

Route::group(['middleware' => 'api'] + ['namespace' => 'Circle33\\Flysystem\\Qcloud\\Http\\Controllers'], function ($router) {
    $router->get(config('qcloud.ui_url') . '/hello', 'FileController@hello')->name('qcloud.file.hello');
});