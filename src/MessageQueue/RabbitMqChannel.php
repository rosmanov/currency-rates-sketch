<?php
declare(strict_types=1);

namespace App\MessageQueue;

use App\MessageQueue\Message\MessageInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exception\AMQPChannelClosedException;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class RabbitMqChannel implements MessageQueueChannelInterface
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var string
     */
    private $exchange;

    /**
     * @var string
     */
    private $routingKey;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        AMQPChannel $channel,
        LoggerInterface $logger,
        string $exchange = '',
        string $routingKey = ''
    ) {
        $this->channel = $channel;
        $this->logger = $logger;
        $this->exchange = $exchange;
        $this->routingKey = $routingKey;
    }

    /**
     * Returns a copy of this object with the specified exchange assigned to it.
     *
     * @param string $exchange
     * @return self
     */
    public function withExchange(string $exchange): self
    {
        $object = clone $this;
        $object->exchange = $exchange;
        return $object;
    }

    /**
     * Returns a copy of this object with the specified routing key assigned to it.
     *
     * @param string $routingKey
     * @return self
     */
    public function withRoutingKey(string $routingKey): self
    {
        $object = clone $this;
        $object->routingKey = $routingKey;
        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function publish(MessageInterface $message): void
    {
        try {
            $this->channel->basic_publish(
                new AMQPMessage($message->toString()),
                $this->exchange,
                $this->routingKey
            );
        } catch (AMQPChannelClosedException $e) {
            $this->logger->error($e->getMessage());
            throw new \RuntimeException($e->getMessage(), 0, $e);
        }
    }
}
