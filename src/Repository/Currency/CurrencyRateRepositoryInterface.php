<?php
declare(strict_types=1);

namespace App\Repository\Currency;

use App\Entity\CurrencyInterface;
use App\Entity\CurrencyRateInterface;

interface CurrencyRateRepositoryInterface {
    /**
     * Searches for single rate of the source currency
     * relative to the target currency.
     *
     * On success, a valid currency rate is returned.
     *
     * @param CurrencyInterface $fromCurrency Source currency
     * @param CurrencyInterface $toCurrency Target currency
     * @param CurrencyRateInterface $default Default value for the case if the rate is not found.
     */
    public function find(
        CurrencyInterface $fromCurrency,
        CurrencyInterface $toCurrency,
        CurrencyRateInterface $default
    ): CurrencyRateInterface;
}
