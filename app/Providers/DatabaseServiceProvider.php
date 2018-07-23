<?php

namespace App\Providers;

use Doctrine\ORM\Tools\Setup;
use Illuminate\Database\Capsule\Manager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class DatabaseServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{   
    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {       
         
    }

    /**
     * Boot in the container
     *
     * @return void
     */
    public function boot()
    {
        $container = $this->getContainer();

        $config = $container->get('config');
        
         $capsule = new Manager();
         $capsule->addConnection($config->get('db.' . env('DB_TYPE')));

         $capsule->setAsGlobal();
         $capsule->bootEloquent();
    }
}
