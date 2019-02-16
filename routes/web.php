<?php

use Circle33\Flysystem\Qcloud\Http\Controllers\QcloudController;

$configUiUrl = config('circle33_qcloud.ui_url');

Route::group([
    'middleware' => 'web',
    'namespace'  => 'Circle33\\Flysystem\\Qcloud\\Http\\Controllers'
], function ($router) use ($configUiUrl) {
    $router->get($configUiUrl, 'QcloudController@index')
        ->name('qcloud.index');
    $router->get($configUiUrl . '/file/{file}', 'QcloudController@show')
        ->name('qcloud.file.show');
});