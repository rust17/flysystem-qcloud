<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Access-Control-Allow-Headers, X-Requested-With');
header('Access-Control-Allow-Methods: *');

$configApiUrl = config('circle33_qcloud.api_url');

Route::group([
    'middleware' => 'api',
    'namespace'  => 'Circle33\\Flysystem\\Qcloud\\Http\\Controllers'
], function ($router) use ($configApiUrl) {
    $router->get($configApiUrl . '/list_contents', 'FilesController@index')
        ->name('qcloud.api.files.index');
    $router->get($configApiUrl . '/exists', 'FilesController@exists')
        ->name('qcloud.api.files.exists');
    $router->get($configApiUrl . '/read', 'FilesController@show')
        ->name('qcloud.api.flies.show');
    $router->post($configApiUrl . '/files', 'FilesController@store')
        ->name('qcloud.api.files.store');
    $router->patch($configApiUrl . '/files/{path}/rename', 'FilesController@rename')
        ->name('qcloud.api.files.rename');
    $router->delete($configApiUrl . '/files/{path}', 'FilesController@destroy')
        ->name('qcloud.api.files.destroy');
    $router->post($configApiUrl . '/files_copy/{path}', 'FilesController@copy')
        ->name('qcloud.api.files.copy');
});
