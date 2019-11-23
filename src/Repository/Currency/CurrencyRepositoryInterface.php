<?php
declare(strict_types=1);

namespace App\Repository\Currency;

use App\Collection\CurrencyCollectionInterface;
use App\Entity\CurrencyInterface;

interface CurrencyRepositoryInterface
{
    /**
     * @param string $code Currency code name such as USD, RUB etc.
     * @param CurrencyInterface $default
     *
     * @return CurrencyInterface
     */
    public function findByCode(string $code, CurrencyInterface $default): CurrencyInterface;

    /**
     * @param string[] $codes Array of currency code names such as USD, RUB etc.
     * @param CurrencyCollectionInterface $default Default item value
     *
     * @return CurrencyCollectionInterface
     */
    public function findByCodeArray(
        array $codes,
        CurrencyCollectionInterface $default
    ): CurrencyCollectionInterface;
}
