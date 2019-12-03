<?php


namespace Domain\Exceptions;

use RuntimeException as BaseException;

/**
 * ServiceException
 */
class ServiceException extends BaseException implements DomainException, BlameServices
{

}