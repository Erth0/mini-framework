<?php

namespace App\Providers;

use App\Session\Session;
use App\Session\SessionStore;
use League\Container\ServiceProvider\AbstractServiceProvider;

class SessionServiceProvider extends AbstractServiceProvider
{   
    /**
     * Provides
     *
     * @var array
     */
    protected $provides = [
        SessionStore::class
    ];

    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {
          $container = $this->getContainer();

          $container->share(SessionStore::class, function() {
              return new Session;
          });
    }
}
