<?php

namespace App\Providers;

use App\Config\Loaders\ArrayLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;
use App\Config\Config;


class ConfigServiceProvider extends AbstractServiceProvider
{   
    /**
     * Provides
     *
     * @var array
     */
    protected $provides = [
        'config',
    ];

    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {
        $this->getContainer()->share('config', function () {
            $loader = new ArrayLoader([
                'app' => base_path('config/app.php'),
                'cache' => base_path('config/cache.php'),
                'db' => base_path('config/db.php')
            ]);

            return (new Config)->load([$loader]);

        });   
    }
}
