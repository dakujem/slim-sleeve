<?php


namespace App\Boot;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;


/**
 * Route Registrator.
 */
class RouteRegistrator implements SlimConfiguratorInterface
{


    /**
     * Note that $this is bound to the Slim App inside the route handlers.
     *
     * @param App $slim
     */
    public function configure(App $slim): void
    {
        $self = $this; // this instance, to be used within the callables below
        $slim->group('/api', function () use ($self, $slim) {

            // Authentication
            $slim->get('/session', '!session:read');
            $slim->post('/session', '!session:create');


            // Self profile
            $slim->get("/self/profile", function (Request $request, Response $response) {
                // TODO return the authenticated user identity
            });

        });

        // Hello World
        $slim->get("[/]", function (Request $request, Response $response) {
            $response->getBody()->write('Hello Worlds!');
            return $response;
        });

        /*
         * Catch-all route to serve a 404 Not Found page if none of the routes match
         * NOTE: make sure this route is defined last
         */
        $slim->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function (Request $request, Response $response) {
            throw new HttpNotFoundException($request);
        });
    }


}
