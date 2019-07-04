<?php


namespace App\Boot;

use Api\Controllers\Session;
use Api\Middleware\RouteGuardFactory;
use Domain\Services\Jwt;
use Psr\Container\ContainerInterface as Container;
use Slim\App;


/**
 * Service container configurator.
 */
class DependencyConfigurator implements SlimConfiguratorInterface
{


    public function configure(App $slim): void
    {
        $container = $slim->getContainer();


#		++-------------------------------------------------------------------++
#		||    Controllers                                                    ||
#		++-------------------------------------------------------------------++


        $container['!session'] = function (Container $container) {
            return new Session();
        };


#		++-------------------------------------------------------------------++
#		||    System services                                                ||
#		++-------------------------------------------------------------------++

        $container['routeGuard'] = function (Container $container) {
            return new RouteGuardFactory($container, 'auth');
        };

        $container['jwt'] = function (Container $container) {
            $s = $container->settings;
            return new Jwt($s['secret'], [
                'ttl' => $s['tokenExpiry'] ?? null,
                'maxlife' => $s['tokenMaxlife'] ?? null,
            ]);
        };


    }

}
