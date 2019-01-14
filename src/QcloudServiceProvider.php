<?php

namespace Circle33\Flysystem\Qcloud;

use Illuminate\Support\ServiceProvider;
use Circle33\Flysystem\Qcloud\QcloudAdapter;

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
        $this->mergeConfiguration(__DIR__ . '/../config/qcloud.php', 'qcloud');
    }

    /**
     * Register package bindings in the container.
     *
     * @return void
     */
    private function registerContainerBindingds()
    {
        $this->app->singleton(QcloudAdapter::class, function ($app) {
            return new QcloudAdapter(config('qcloud.secretId', config('qcloud.secretKey'), config('qcloud.bucket'), config('qcloud.region')));
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
    }

    /**
     * Publish package configuration.
     *
     * @return void
     */
    public function publishConfiguration()
    {
        $this->publishes([
            __DIR__ . '/../config/qcloud.php' => config_path('qcloud.php'),
        ]);
    }

    /**
     * Load and publish package views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'qcloud');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/qcloud'),
        ]);
    }

    /**
     * Publish package assets.
     *
     * @return void
     */
    public function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../public/assets' => public_path('vendor/qcloud'),
        ], 'assets');
    }
}