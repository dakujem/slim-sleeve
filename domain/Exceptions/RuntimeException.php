<?php


namespace Domain\Exceptions;


use RuntimeException as BaseException;

/**
 * Application error that results from the direct user interaction.
 */
class RuntimeException extends BaseException implements DomainException, BlameConsumer
{

}