<?php

/**
 * HTTP request dispatcher.
 */

use App\Boot\DependencyConfigurator;
use App\Boot\MiddlewareConfigurator;
use App\Boot\RouteRegistrator;
use App\Boot\SlimFactory;
use Slim\App;

/**/
// TODO comment these out
// TODO add Tracy
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**/

// Root dir
$root = __DIR__ . '/..';

// Vendor class autoloader
require $root . '/vendor/autoload.php';


// Define configurators
$configurators = [
    // Configures settings
    function (App $slim) use ($root) {
        $settings = require $root . '/config/settings.php';
        $slim->getContainer()->set('settings', $settings);
    },
    // Configures dependencies
    DependencyConfigurator::class,
    // Configures middleware
    MiddlewareConfigurator::class,
    // Registers routes
    RouteRegistrator::class,
];

// Create and bootstrap an App instance
return SlimFactory::build($configurators);

