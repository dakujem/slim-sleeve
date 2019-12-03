<?php


namespace Api\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyRequestHandler implements RequestHandlerInterface
{
    private $callable;
    private $response;

    public function __construct(callable $callable, ResponseInterface $response)
    {
        $this->callable = $callable;
        $this->response = $response;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return call_user_func($this->callable, $request, $this->response);
    }

    function getRawResponse(): ResponseInterface
    {
        return $this->response;
    }
}
