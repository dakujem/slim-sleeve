<?php


namespace Domain\Tasks;


/**
 * Tasks are single-purpose objects representing something that _should be done_.
 * A task is supposed to be consumed/executed by an interactor.
 *
 * Parameters of a task should be provided as constructor arguments.
 * Tasks are usually serializable (otherwise there is usually no need to create them).
 * @see \JsonSerializable
 *
 * $task = new SendWelcomeEmailTask($currentUser, $currentTime); // parameters are given when creating a task
 * $storage->storeTask(serialize($task)); // can be serialized to be used later or to be enqueued
 *
 * $task = $storage->getNextTask();
 * $sender = $di->get('SendWelcomeEmail');
 * $sender->act($task);
 */
interface Task
{

}