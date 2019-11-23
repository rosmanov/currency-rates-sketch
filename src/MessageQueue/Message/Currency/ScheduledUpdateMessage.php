<?php
declare(strict_types=1);

namespace App\MessageQueue\Message\Currency;

use App\Entity\CurrencyInterface;
use App\Entity\VoidCurrency;
use App\MessageQueue\Message\MessageInterface;

/**
 * Message for currency rate updates.
 */
class ScheduledUpdateMessage implements MessageInterface
{
    private const FROM_CURRENCY_KEY = 'fromCurrency';
    private const TO_CURRENCY_KEY = 'toCurrency';

    /**
     * @var CurrencyInterface
     */
    private $fromCurrency;

    /**
     * @var CurrencyInterface
     */
    private $toCurrency;

    public function __construct(
        CurrencyInterface $fromCurrency,
        CurrencyInterface $toCurrency
    ) {
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
    }

    /**
     * Converts the current object to array representation
     *
     * @return array
     */
    private function toArray(): array
    {
        return [
            self::FROM_CURRENCY_KEY => $this->fromCurrency,
            self::TO_CURRENCY_KEY => $this->toCurrency,
        ];
    }

    /**
     * Converts the current object to string representation
     *
     * @return string
     */
    public function toString(): string
    {
        return serialize($this);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->fromCurrency = $data[self::FROM_CURRENCY_KEY] ?? new VoidCurrency();
        $this->toCurrency = $data[self::TO_CURRENCY_KEY] ?? new VoidCurrency();
    }
}
