<?php

namespace Codemen\Installer\Providers;

use Codemen\Installer\Middleware\CanInstall;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__ . '/../config/installer.php' => base_path('config/installer.php'),
        ], 'CodemenInstaller');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('installer'),
        ], 'CodemenInstaller');

        $this->publishes([
            __DIR__ . '/../views' => base_path('resources/views/vendor/installer'),
        ], 'CodemenInstaller');
    }

    /**
     * Bootstrap the application events.
     *
     * @param Router $router
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstall::class]);
    }
}
