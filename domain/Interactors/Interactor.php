<?php


namespace Domain\Interactors;


/**
 * Interactors represent use cases, something that the application _does_.
 * An interactor is a _service_ that interacts with other services and domain objects (its _context_).
 *
 * The context is given in form of arguments to the `act` method.
 * Service dependencies are injected using constructor injection.
 * _Only_ the context given as the arguments should be changed by the interactor.
 * Interactors are suitable for processing Tasks.
 *
 * $di->registerSingleton('SendWelcomeEmail', function($di){
 *      return new SendWelcomeEmail($di->get('mailer'));
 * });
 * $sender = $di->get('SendWelcomeEmail');
 * $sender->act($currentUser, $currentTime);
 */
interface Interactor
{

    function act(/* ... $context */);

}