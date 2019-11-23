<?php
declare(strict_types=1);

namespace App\MessageQueue\Consumer\Currency;

use App\MessageQueue\Consumer\AbstractRabbitMqConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqUpdateConsumer extends AbstractRabbitMqConsumerInterface
{
    /**
     * {@inheritDoc}
     */
    protected function handleRabbitMq(AMQPMessage $message)
    {
        // XXX handle message
    }
}
