<?php


namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;


/**
 * RequestPathMethodRule
 *
 * Inspired by Tuupola\Middleware\JwtAuthentication\RequestPathRule
 *
 * - adds selection of methods to pass-though
 * - adds exact match ignore (endpoints)
 */
class RequestPathMethodRule
{

    /**
     * Stores all the options passed to the rule
     */
    protected $options = [
        "path" => ["/"],
        "ignore" => [],
    ];


    /**
     * Create a new rule instance
     *
     * @param string[] $options
     * @return void
     */
    public function __construct($options = [])
    {
        $this->options = array_merge($this->options, $options);
    }


    /**
     * @param ServerRequestInterface $request
     * @return boolean
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $uri = '/' . $request->getUri()->getPath();
        $uri = preg_replace('#/+#', '/', $uri);

        $method = $request->getMethod();

        $unpack = function ($passthrough, $passthroughMethods) {
            if (is_int($passthrough) && !is_array($passthroughMethods)) {
                $passthrough = $passthroughMethods;
                $passthroughMethods = null;
            } elseif (is_string($passthrough) && $passthroughMethods !== null && !is_array($passthroughMethods)) {
                $passthroughMethods = [$passthroughMethods];
            }
            return [$passthrough, $passthroughMethods];
        };

        /* If request path matches ignore path (passthrough) we should not authenticate. */
        foreach ((array)($this->options['ignorePath'] ?? []) as $passthrough => $passthroughMethods) {
            [$passthrough, $passthroughMethods] = $unpack($passthrough, $passthroughMethods);
            $passthrough = rtrim($passthrough, '/');
            if (
                !!preg_match("@^{$passthrough}(/.*)?$@", $uri) &&
                (!is_array($passthroughMethods) || in_array($method, $passthroughMethods))
            ) {
                return false;
            }
        }

        /* If request path matches ignore endpoint exactly (passthrough) we should not authenticate. */
        foreach ((array)($this->options['ignoreEndpoint'] ?? []) as $passthrough => $passthroughMethods) {
            [$passthrough, $passthroughMethods] = $unpack($passthrough, $passthroughMethods);
            $passthrough = rtrim($passthrough, '/');
            if (
                $uri === $passthrough && // exact match
                (!is_array($passthroughMethods) || in_array($method, $passthroughMethods))
            ) {
                return false;
            }
        }

        /* Otherwise check if path matches and we should authenticate. */
        foreach ((array)($this->options['path'] ?? []) as $path) {
            $path = rtrim($path, '/');
            if (!!preg_match("@^{$path}(/.*)?$@", $uri)) {
                return true;
            }
        }

        return false;
    }

}
