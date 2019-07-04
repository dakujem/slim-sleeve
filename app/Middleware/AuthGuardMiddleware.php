<?php


namespace Api\Middleware;


use Api\Auth\Authorizator;
use Api\Auth\TokenHelper;
use Api\Helpers\ResponseHelper;
use Domain\Exceptions\AccessViolation;
use Domain\Exceptions\LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Middleware for route authorization using scopes.
 */
class AuthGuardMiddleware implements MiddlewareInterface
{


	private $scopes = [];
	private $auth;

	/**
	 * @param array                 $scopes       pozadovane "scopes"
	 * @param Authorizator|callable $authorizator Authorizator, alebo callable provider, ktory vrati Autorizator
	 */
	public function __construct(array $scopes, $authorizator)
	{
		$this->scopes = $scopes;
		$this->auth = $authorizator;
	}


	/**
	 * @param string|array          $scopes       pole alebo comma-delimited string obsahujuci pozadovane scopes
	 * @param Authorizator|callable $authorizator Authorizator, alebo callable provider, ktory vrati Autorizator
	 * @return AuthGuardMiddleware
	 */
	static function instance($scopes, $authorizator): self
	{
		return new static(TokenHelper::scopeAsArray($scopes), $authorizator);
	}


	/**
	 * Slim middleware invokation.
	 *
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface      $response
	 * @param callable               $next
	 * @return ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
	{
		return $this->process($request, new LazyRequestHandler($next, $response));
	}


	/**
	 * Middleware process request.
	 *
	 * @param ServerRequestInterface  $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 */
	function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		try {
			// Vyhodi vynimku, ked nie je niektory zo scopes povoleny
			$this->resolveAuthorizator()->protect($this->scopes);
		} catch (AccessViolation $e) {
			if ($handler instanceof LazyRequestHandler) {
				return ResponseHelper::jsonErrorException($handler->getRawResponse(), $e);
			}
			throw $e;
		}

		return $handler->handle($request);
	}


	private function resolveAuthorizator(): Authorizator
	{
		if (!$this->auth instanceof Authorizator && is_callable($this->auth)) {
			$this->auth = call_user_func($this->auth);
		}
		if (!$this->auth instanceof Authorizator) {
			throw new LogicException('Invalid authorizator provided.');
		}
		return $this->auth;
	}
}