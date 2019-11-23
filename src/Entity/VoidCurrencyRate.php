<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * Represents the absence of the currency rate
 * (Null object pattern)
 */
class VoidCurrencyRate implements CurrencyRateInterface
{
    /**
     * @var CurrencyInterface
     */
    private $currency;
    /**
     * @var float
     */
    private const VALUE = -INF;

    public function __construct()
    {
        $this->currency = new VoidCurrency();
    }

    /**
     * {@inheritDoc}
     */
    public function toCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    /**
     * {@inheritDoc}
     */
    public function fromCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    /**
     * {@inheritDoc}
     */
    public function value(): float
    {
        return self::VALUE;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(): bool
    {
        return false;
    }
}
