<?php


namespace Domain\Exceptions;


use LogicException as BaseException;

/**
 * Application logic failure.
 */
class LogicException extends BaseException implements DomainException, BlameDevelopers
{

}