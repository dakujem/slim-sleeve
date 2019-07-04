<?php


namespace App\Boot;

use Dakujem\Sleeve;
use Interop\Container\ContainerInterface;
use LogicException;
use Slim\App;
use Slim\Factory\AppFactory;


/**
 * A Slim App Factory.
 */
final class SlimFactory
{


	/**
	 * Create and configure an instance of Slim v4 App.
	 *
	 * @param SlimConfiguratorInterface[] $configurators
	 * @param ContainerInterface|null     $container
	 * @return App
	 * @throws LogicException
	 */
	public static function build(array $configurators = [], ContainerInterface $container = null): App
	{
		return self::configure(AppFactory::create(
			null, // let the AppFactory detect & configure the request factory
			$container ?? new Sleeve() // a simple extension of Pimple Container
		// let the AppFactory provide the rest of the dependencies
		), $configurators);
	}


	/**
	 * Configure given App instance using decorators.
	 *
	 * Each decorator can be one of:
	 * - an instance of SlimConfiguratorInterface implementation
	 * - a string name of such a class
	 * - a callable provider of such an instance
	 * - a callable that directly decorates the slim app instance (passed in as the first argument)
	 *
	 * @param App   $slim
	 * @param array $configurators
	 * @return App
	 */
	public static function configure(App $slim, array $configurators = []): App
	{
		foreach ($configurators as $c) {
			$callable = false;
			if (is_string($c) && class_exists($c)) {
				$c = new $c();
			} elseif (is_callable($c)) {
				$callable = true;
				$c = call_user_func($c, $slim);
			}
			if ($c instanceof SlimConfiguratorInterface) {
				$c->configure($slim);
			} elseif (!$callable) {
				throw new LogicException(sprintf('Improper Slim configurator, need an instance of %s, got %s.', SlimConfiguratorInterface::class, is_object($c) ? 'an instance of ' . get_class($c) : gettype($c)));
			}
		}
		return $slim;
	}
}
