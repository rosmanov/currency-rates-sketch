<?php
declare(strict_types=1);

namespace App\MessageQueue;

use App\MessageQueue\Message\MessageInterface;

/**
 * @todo Add publishBatch() method.
 */
interface MessageQueueChannelInterface
{
    /**
     * Sends single message to the message queue
     * @param MessageInterface $message Message to be sent to the message queue
     *
     * @throws \RuntimeException
     */
    public function publish(MessageInterface $message): void;
}
