<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Access-Control-Allow-Headers, X-Requested-With');
header('Access-Control-Allow-Methods: *');

Route::group(['middleware' => 'api'] + ['namespace' => 'Circle33\\Flysystem\\Qcloud\\Http\\Controllers'], function ($router) {
    $router->get(config('qcloud.api_url') . '/listContents/{directory}', 'FilesController@index')
        ->name('qcloud.api.files.index');
    $router->get(config('qcloud.api_url') . '/hasFile/{path}', 'FilesController@has')
        ->name('qcloud.api.files.has');
    $router->get(config('qcloud.api_url') . '/read/{path}', 'FilesController@show')
        ->name('qcloud.api.flies.show');
    $router->post(config('qcloud.api_url') . '/files', 'FilesController@store')
        ->name('qcloud.api.files.store');
    $router->patch(config('qcloud.api_url') . '/files', 'FilesController@rename')
        ->name('qcloud.api.files.rename');
    $router->delete(config('qcloud.api_url') . '/files/{path}', 'FilesController@destroy')
        ->name('qcloud.api.files.destroy');
    $router->post(config('qcloud.api_url') . '/filesCopy/{path}', 'FilesController@copy')
        ->name('qcloud.api.files.copy');
});