<?php


namespace Domain\Exceptions;


/**
 * Blame the Developers!
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
 * For the other type of errors see
 * @see BlameConsumer
 * @see BlameServices
 */
interface BlameDevelopers
{

}