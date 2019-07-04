<?php


namespace Domain\Exceptions;


use Slim\Http\StatusCode;

/**
 * A user's action violates access restrictions.
 *
 * This can be an authorization, authentication or other type of a problem.
 */
class AccessViolation extends RuntimeException
{

}