<?php


namespace Services\Tokens;

use Carbon\CarbonImmutable;
use Firebase\JWT\JWT as Lib;
use LogicException;


/**
 * JSON Web Token service wrapper.
 */
final class Jwt
{

    const DEFAULT_ALGO = 'HS256';
    const DEFAULT_TOKEN_TTL_MINUTES = 60; // 60 minutes by default

    /**
     * @var string API secret
     */
    private $secret;

    /**
     * @var int token TTL in minutes
     */
    private $ttl;

    /**
     * @var string hash algorithm (default)
     */
    private $algo;


    function __construct(string $apiSecret, array $config = [])
    {
        if (strlen($apiSecret) < 20) {
            throw new LogicException('API secret too short.');
        }
        $this->secret = $apiSecret;
        $this->algo = $config['algo'] ?? self::DEFAULT_ALGO;
        $this->ttl = $config['ttl'] ?? self::DEFAULT_TOKEN_TTL_MINUTES;
    }


    function encode($claims): string
    {
        return Lib::encode($claims, $this->secret, $this->algo);
    }


    function decode($token): object
    {
        return Lib::decode($token, $this->secret, [$this->algo]);
    }


    /**
     * Generates a new JWT.
     *
     * Sets 3 "registered claims" by default:
     * - `exp` (expiry time)
     * - `nbf` (not before)
     * - `iat` (issued at)
     * These claims limit the token validity and it is useful to set them all the time.
     * The default claims cen be overridden or removed by overriding them with null value.
     *
     * @link https://tools.ietf.org/html/rfc7519 JWT RFC
     *
     * @param array $claims
     * @return string
     */
    function generate(array $claims): string
    {
        $iat = CarbonImmutable::now(); // "issued at" / token creation time
        $exp = $iat->addMinutes($this->ttl); // token expires at
        $defaults = [
            'exp' => $exp->unix(),
            'iat' => $iat->unix(),
            'nbf' => $iat->unix(),
        ];
        $notNull = function ($claim) {
            return $claim !== null;
        };
        return $this->encode(array_filter(array_merge($defaults, $claims), $notNull));
    }


}
