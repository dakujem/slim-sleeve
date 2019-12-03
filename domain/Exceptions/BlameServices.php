<?php


namespace Domain\Exceptions;


/**
 * Blame third-party Services.
 *
 * An error that results from interaction with third-party services
 * that do not behave as expected.
 *
 * The system should be able to run even when this issue happens.
 * The error should be logged and the system should recover.
 * Neither the user nor the developers or administrators should be expected to take action
 * besides waiting waiting until the third-party service starts to behave.
 *
 * These errors include (but are not limited to):
 * - remote service is temporarily unavailable
 * - remote service has crashed or was hijacked by pirates
 * - network communication has failed but is expected to come to life soon
 *
 * For the other type of errors see
 * @see BlameDevelopers
 * @see BlameConsumer
 */
interface BlameServices
{

}