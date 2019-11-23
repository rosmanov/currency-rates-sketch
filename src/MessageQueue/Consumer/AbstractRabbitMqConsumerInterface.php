<?php
declare(strict_types=1);

namespace App\MessageQueue\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractRabbitMqConsumerInterface implements ConsumerInterface
{
    abstract protected function handleRabbitMq(AMQPMessage $message);

    /**
     * @param mixed $message
     * @throws \InvalidArgumentException
     */
    final public function handle($message): void
    {
        if ($message instanceof AMQPMessage) {
            $this->handleRabbitMq($message);
        }

        throw new \InvalidArgumentException();
    }
}
