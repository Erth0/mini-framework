<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Auth\Recaller;
use App\Cookie\CookieJar;
use App\Auth\Hashing\Hasher;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;
use App\Auth\Providers\DatabaseProvider;
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
            $provider = new DatabaseProvider(
                $container->get(EntityManager::class)
            );

            return new Auth(
                $container->get(Hasher::class),
                $container->get(SessionStore::class),
                new Recaller(),
                $container->get(CookieJar::class),
                $provider
            );
        });
    }
}
