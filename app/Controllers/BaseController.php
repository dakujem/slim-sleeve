<?php


namespace Api\Controllers;

use Api\Helpers\ResponseHelper;
use Fig\Http\Message\StatusCodeInterface as StatusCode;
use NotImplementedException;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;


/**
 * BaseController
 */
abstract class BaseController
{


    function __invoke(Request $request, Response $response, ...$args): ResponseInterface
    {
        $requestHandler = $this->requestHandler($request->getMethod());
        if ($requestHandler === null) {
            throw new NotImplementedException('Neviem ako dalej. Pomozte mi.');
        }
        return call_user_func($requestHandler, $request, $response, ...$args);
    }


    /**
     * @return callable[]
     */
    protected function requestHandlers(): array
    {
        return [
            'GET' => [$this, 'read'],
            'POST' => [$this, 'create'],
            'DELETE' => [$this, 'delete'],
            'PATCH' => [$this, 'update'],
            'PUT' => [$this, 'replace'],
            'OPTIONS' => [$this, 'options'],
        ];
    }


    /**
     * @param string $method
     * @return callable|NULL
     */
    protected function requestHandler(string $method): ?callable
    {
        return $this->requestHandlers() [$method] ?? null;
    }


    /**
     * OPTIONS request handler.
     *
     * @param Request  $request
     * @param Response $response
     */
    function options(Request $request, Response $response): ResponseInterface
    {
        $allowed = array_keys(array_filter($this->requestHandlers(), function ($handler) {
            return is_callable($handler);
        }));
        //TODO handle preflight & (regular) options requests
        // poznamka: CORS je zatial nastavene tak, ze tato implementacia nie je potrebna. Vid middleware konfiguraciu.
    }


    protected function respondNonEmpty(Response $response, $data): ResponseInterface
    {
        if ($data === null) {
            $data = [
                'error' => [
                    'message' => 'Resource not found.',
                ],
            ];
            return ResponseHelper::json($response, $data, StatusCode::STATUS_NOT_FOUND);
        }
        return ResponseHelper::jsonData($response, $data);
    }

}
