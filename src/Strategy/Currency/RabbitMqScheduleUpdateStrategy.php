<?php
declare(strict_types=1);

namespace App\Strategy\Currency;

use App\Entity\CurrencyInterface;
use App\MessageQueue\MessageQueueChannelInterface;
use App\MessageQueue\Message\Currency\ScheduledUpdateMessage;
use App\Repository\Currency\CurrencyRateRepositoryInterface;

class RabbitMqScheduleUpdateStrategy implements CurrencyRateMissingStrategyInterface
{
    /**
     * @var MessageQueueChannelInterface
     */
    private $messageQueueChannel;

    public function __construct(MessageQueueChannelInterface $messageQueueChannel)
    {
        $this->messageQueueChannel = $messageQueueChannel;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(
        CurrencyInterface $fromCurrency,
        CurrencyInterface $toCurrency,
        CurrencyRateRepositoryInterface $rateRepo
    ): void {
        $message = new ScheduledUpdateMessage($fromCurrency, $toCurrency, $rateRepo);

        $this->messageQueueChannel->publish($message);
    }
}
