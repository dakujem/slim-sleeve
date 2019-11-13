<?php


namespace App\Boot;

use App\Middleware\RequestPathMethodRule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\App;
use Tuupola\Middleware\JwtAuthentication;
use Tuupola\Middleware\JwtAuthentication\RequestMethodRule;


/**
 * Middleware configurator.
 *
 * If you have a pile of middleware to configure, it is a good idea to split it into multiple configurators.
 * Mind the order of middleware registration though.
 *
 * WARNING:
 *        The middleware is executed in LIFO manner - the last middleware added is executed first.
 */
class MiddlewareConfigurator implements SlimConfiguratorInterface
{


    public function configure(App $slim): void
    {
        $container = $slim->getContainer();


#		++-------------------------------------------------------------------++
#		||    Routing                                                        ||
#		++-------------------------------------------------------------------++

        $slim->addRoutingMiddleware();


#		++-------------------------------------------------------------------++
#		||    Error Handling                                                 ||
#		++-------------------------------------------------------------------++

        $slim->addErrorMiddleware($container->settings['dev'], TRUE, TRUE);


#		++-------------------------------------------------------------------++
#		||    Authentication & Authorization & JWT                           ||
#		++-------------------------------------------------------------------++


        // WARNING:
        //      It is important that this middleware runs before any authorization logic happens,
        //      otherwise the token scope limiting would fail.
        $slim->add(function (Request $request, Handler $next) use ($container) {
            $token = $request->getAttribute('token');

            // If a valid decoded token is present:
            // - authenticate the "user" service
            // - add a valid token-based "auth" service
            if ($token instanceof AccessToken) {
                // configure the (token) auth service
                $container['auth'] = $container->authFactory->forToken($token);
                // configure the user service
                $container['user']->authenticateAs($token->getClaim('aud'));
            }

            return $next->handle($request);
        });


        $slim->add(new JwtAuthentication([
            'header' => 'authorization',
            'path' => '/api',
            'rules' => [
                new RequestPathMethodRule([
                    'path' => '/api',
                    // do not authorize POST:/api/session
                    'ignoreEndpoint' => [
                        '/api/session' => ['POST'],
                    ],
                ]),
                new RequestMethodRule([
                    'ignore' => ['OPTIONS'],
                ]),
            ],
            'secure' => true,
            'relaxed' => ['localhost',], // development - no need for HTTPS
            'before' => function (Request $request, array $arguments) use ($container) {
                // Do something with the decoded token, e.g. wrap the decoded token into an object
                // return $request->withAttribute('token', new AccessToken($arguments['decoded'], $arguments['token'] ?? null));
            },
            'error' => function (Response $response, array $arguments) {
                $data['error'] = [
                    'message' => $arguments['message'],
                ];
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->getBody()
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            },
            'secret' => $container->settings['secret'],
        ]));


#		++-------------------------------------------------------------------++
#		||    CORS                                                           ||
#		++-------------------------------------------------------------------++

        // TODO
        $slim->add(function (Request $request, Handler $next) {
            $response = $next->handle($request);
            return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://mysite')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });


    }

}
