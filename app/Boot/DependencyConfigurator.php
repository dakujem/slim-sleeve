<?php


namespace App\Boot;

use Api\Controllers\SessionController;
use Api\Middleware\RouteGuardFactory;
use Dakujem\Latter\View;
use Domain\Services\Jwt;
use Latte\Engine;
use Latte\Loaders\FileLoader;
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
            return new SessionController();
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

        $container->set('view', function () use ($container) {
            $defaultParams = [
                'projectName' => 'My Awesome Project',
            ];
            $view = new View($defaultParams);

            // optionally set an engine factory
            $view->engine(function () use ($container): Engine {
                return $container->get('latte');
            });

            $view->alias('page.latte', 'page');

            return $view;
        });

        $container->set('latte', $container->factory(function () use ($container) {
            $engine = new Engine();

            // Configure the file loader to search for templates in a dedicated directory.
            $loader = new FileLoader(__DIR__ . '/../View/Templates');
            $engine->setLoader($loader);

            // Set a temporary directory, where compiled Latte templates will be stored.
//            $engine->setTempDirectory($container->settings['view-temp-dir']);

            return $engine;
        }));

    }

}
