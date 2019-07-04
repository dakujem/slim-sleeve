<?php


namespace Api\Middleware;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 *
 */
class RouteGuardFactory
{
	private $container;
	private $key;

	public function __construct(ContainerInterface $container, string $key = 'auth')
	{
		$this->container = $container;
		$this->key = $key;
	}


	/**
	 * Vytvori middleware, ktory bude chranit pozadovane "scopes".
	 *
	 * Pouzitie:
	 * $routeGuard = $container->get('routeGuard'); // instanceof RouteGuardFactory
	 * $app->add(   $routeGuard->require('global_scope') );
	 * $route->add( $routeGuard->require('route_scope')  );
	 *
	 * @param $scopes
	 * @return callable
	 */
	function require($scopes): callable
	{
		// podstata je v tom, ze z kontajneru sa vytahuje autorizator az v momente, kedy ho middleware potrebuje
		$authResolver = function () {
			return $this->container->get($this->key);
		};
		return function (RequestInterface $request, ResponseInterface $response, callable $next) use ($scopes, $authResolver) {
			$mw = AuthGuardMiddleware::instance($scopes, $authResolver);
			return call_user_func($mw, $request, $response, $next);
		};
	}
}