<?php

namespace Circle33\Flysystem\Qcloud;

use Storage;
use Illuminate\Support\ServiceProvider;
use Circle33\Flysystem\Qcloud\QcloudAdapter;
use League\Flysystem\Filesystem;

class QcloudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package service.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();

        $this->publishConfiguration();

        $this->loadViews();

        $this->publishAssets();
    }

    /**
     * Register package bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfiguration();

        $this->registerContainerBindingds();
    }

    /**
     * Merge package configuration
     *
     * @return void
     */
    private function mergeConfiguration()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/qcloud.php', 'circle33_qcloud');
    }

    /**
     * Register package bindings in the container.
     *
     * @return void
     */
    private function registerContainerBindingds()
    {
        Storage::extend('qcloud_oss', function ($app, $config) {
            $adapter    = new QcloudAdapter($config['secretId'], $config['secretKey'], $config['bucket'], $config['region']);

            $filesystem = new Filesystem($adapter);

            return $filesystem;
        });
    }

    /**
     * Register package routes.
     *
     * @return void
     */
    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Publish package configuration.
     *
     * @return void
     */
    public function publishConfiguration()
    {
        $this->publishes([
            __DIR__ . '/../config/qcloud.php' => config_path('circle33_qcloud.php'),
        ], 'config');
    }

    /**
     * Load and publish package views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'qcloud');

        // $this->publishes([
        //     __DIR__ . '/../resources/views' => resource_path('views/vendor/circle33_qcloud'),
        // ]);
    }

    /**
     * Publish package assets.
     *
     * @return void
     */
    public function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../public/assets' => public_path('vendor/circle33_qcloud'),
        ], 'assets');
    }
}