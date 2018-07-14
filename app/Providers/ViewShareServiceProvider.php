<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Views\View;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use App\Session\Flash;


class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{   

    public function boot()
    {
        $container = $this->getContainer();
        
        $container->get(View::class)->share([
            'config' => $container->get('config'),
            'auth' => $container->get(Auth::class),
            'flash' => $container->get(Flash::class)
        ]);
    }

    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {
       //        
    }
}
