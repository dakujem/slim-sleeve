<?php


namespace Domain\Exceptions;


use RuntimeException as BaseException;

/**
 * Application logic error that results from the direct user interaction.
 *
 * The user is supposed to be able to recover from the error,
 * for example by making a different request or by calling other actions prior to this one.
 *
 * These errors include (but are not limited to):
 * - the input sent to the server is not valid
 * - the kind of issue usually present between a keyboard and a chair
 * - invalid operation, authorization failure, inaccessible data or an action not permitted
 *
 * For the other type of errors that the user is not responsible for (like a bug or data corruption), see
 * @see LogicException
 */
class RuntimeException extends BaseException implements DomainException
{

}