<?php


namespace Domain\Exceptions;


/**
 * Blame the Consumer (User)...
 *
 * Application logic error that results from the direct user interaction.
 *
 * The user is supposed to be able to recover from the error,
 * for example by making a different request or by calling other actions prior to this one.
 *
 * These errors include (but are not limited to):
 * - the input sent to the server is not valid
 * - invalid operation, authorization failure, inaccessible data or an action not permitted
 * - the kind of issue usually present between a keyboard and a chair, in general
 *
 * For the other type of errors see
 * @see BlameDevelopers
 * @see BlameServices
 */
interface BlameConsumer
{

}