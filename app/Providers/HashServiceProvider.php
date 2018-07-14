<?php

namespace App\Providers;

use App\Auth\Hashing\Hasher;
use League\Container\ServiceProvider\AbstractServiceProvider;
use App\Auth\Hashing\BcryptHasher;

class HashServiceProvider extends AbstractServiceProvider
{   
    /**
     * Provides
     *
     * @var array
     */
    protected $provides = [
        Hasher::class
    ];

    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Hasher::class, function() {
            return new BcryptHasher();
        });
        
    }
}
