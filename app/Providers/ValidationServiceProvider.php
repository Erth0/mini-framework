<?php

namespace App\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Valitron\Validator;
use App\Rules\ExistsRule;
use Doctrine\ORM\EntityManager;

class ValidationServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{   

    /**
     * Register in the container
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        Validator::addRule('exists', function($field, $value, $params, $fields) {
            $rule = new ExistsRule($this->getContainer()->get(EntityManager::class));

            return $rule->validate($field, $value, $params, $fields);
        }, 'has been arlready taken');
    }
}
