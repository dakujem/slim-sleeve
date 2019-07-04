<?php


namespace App\Boot;

use Slim\App;


/**
 * A generic configurator interface.
 */
interface SlimConfiguratorInterface
{

    function configure(App $slim): void;

}
