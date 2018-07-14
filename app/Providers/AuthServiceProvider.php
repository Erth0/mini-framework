<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Auth\Hashing\Hasher;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AuthServiceProvider extends AbstractServiceProvider
{   
    /**
     * Provides
     *
     * @var array
     */
    protected $provides = [
        Auth::class
    ];

    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();     
        
        $container->share(Auth::class, function () use ($container) {
            return new Auth(
                $container->get(EntityManager::class),
                $container->get(Hasher::class),
                $container->get(SessionStore::class)

            );
        });
    }
}
