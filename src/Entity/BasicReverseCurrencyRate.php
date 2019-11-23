<?php
declare(strict_types=1);

namespace App\Entity;

class BasicReverseCurrencyRate implements CurrencyRateInterface
{
    /**
     * @var CurrencyRateInterface
     */
    private $reverseRate;

    public function __construct(CurrencyRateInterface $originalRate) {
        $this->reverseRate = new BasicCurrencyRate(
            $originalRate->fromCurrency(),
            $originalRate->toCurrency(),
            1 / $originalRate->value()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toCurrency(): CurrencyInterface
    {
        return $this->reverseRate->toCurrency();
    }

    /**
     * {@inheritDoc}
     */
    public function fromCurrency(): CurrencyInterface
    {
        return $this->reverseRate->fromCurrency();
    }

    /**
     * {@inheritDoc}
     */
    public function value(): float
    {
        return $this->reverseRate->value();
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(): bool
    {
        return $this->reverseRate->isValid();
    }
}
