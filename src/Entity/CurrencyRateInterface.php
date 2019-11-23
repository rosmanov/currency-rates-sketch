<?php
declare(strict_types=1);

namespace App\Entity;

use App\Contract\ValidStateContainerInterface;

/**
 * A currency rate.
 */
interface CurrencyRateInterface extends ValidStateContainerInterface
{
    /**
     * Returns the target currency
     * (currency which is converted to the base currency)
     *
     * @return CurrencyInterface
     */
    public function toCurrency(): CurrencyInterface;

    /**
     * Returns the base currency
     * (currency the target currency is converted to)
     *
     * @return CurrencyInterface
     */
    public function fromCurrency(): CurrencyInterface;

    /**
     * Returns the currency rate value
     *
     * @return float
     */
    public function value(): float;
}
