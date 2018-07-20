<?php

namespace App\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use App\Cookie\CookieJar;

class CookieServiceProvider extends AbstractServiceProvider
{   
    /**
     * Provides
     *
     * @var array
     */
    protected $provides = [
        CookieJar::class
    ];

    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {
          $container = $this->getContainer();

          $container->share(CookieJar::class, function() use ($container) {
              return new CookieJar();
          });
    }
}
