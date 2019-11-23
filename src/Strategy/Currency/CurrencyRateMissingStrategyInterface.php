<?php
declare(strict_types=1);

namespace App\Strategy\Currency;

use App\Entity\CurrencyInterface;
use App\Repository\Currency\CurrencyRateRepositoryInterface;

/**
 * Handles the case when the client code signals about currency rate
 * missing in the currency rate repository.
 */
interface CurrencyRateMissingStrategyInterface
{
    /**
     * @param CurrencyInterface $fromCurrency
     * @param CurrencyInterface $toCurrency
     * @param CurrencyRateRepositoryInterface $rateRepo
     */
    public function handle(
        CurrencyInterface $fromCurrency,
        CurrencyInterface $toCurrency,
        CurrencyRateRepositoryInterface $rateRepo
    ): void;
}
