<?php
declare(strict_types=1);

namespace App\Entity;

class BasicCurrencyRate implements CurrencyRateInterface
{
    /**
     * @var CurrencyInterface
     */
    private $toCurrency;

    /**
     * @var CurrencyInterface
     */
    private $fromCurrency;

    /**
     * @var float
     */
    private $value;

    public function __construct(
        CurrencyInterface $toCurrency,
        CurrencyInterface $fromCurrency,
        float $value
    ) {
        $this->toCurrency = $toCurrency;
        $this->fromCurrency = $fromCurrency;
        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function toCurrency(): CurrencyInterface
    {
        return $this->toCurrency;
    }

    /**
     * {@inheritDoc}
     */
    public function fromCurrency(): CurrencyInterface
    {
        return $this->fromCurrency;
    }

    /**
     * {@inheritDoc}
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(): bool
    {
        return $this->value > 0.0;
    }
}
