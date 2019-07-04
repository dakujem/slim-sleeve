<?php


namespace Domain\Exceptions;


use LogicException as BaseException;

/**
 * Application logic failure.
 *
 * This kind of a failure has to be solved by developer or admin intervention.
 * The user is either not able to, not supposed to or not expected to recover from the issue.
 *
 * These failures include (but are not limited to):
 * - a bug
 * - application design flaw
 * - persistent data corruption
 * - broken features, unfinished features
 * - well, it's broken
 *
 * For the other type of errors that the user is supposed to recover from, see
 * @see RuntimeException
 */
class LogicException extends BaseException implements DomainException
{

}