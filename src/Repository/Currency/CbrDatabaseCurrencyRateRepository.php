<?php
declare(strict_types=1);

namespace App\Repository\Currency;

use App\Entity\CurrencyInterface;
use App\Entity\CurrencyRateInterface;

class CbrDatabaseCurrencyRateRepository implements CurrencyRateRepositoryInterface
{
    // XXX Maybe get from external enum-like thing? Or even inject a "scope id provider"?
    // We might store the constants in the interface as well.
    private const SCOPE_ID = 1;

    /**
     * @var DatabaseCurrencyRateRepository
     */
    private $repository;

    public function __construct(DatabaseCurrencyRateRepository $repository)
    {
        $this->repository = $repository->withScope(self::SCOPE_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function find(CurrencyInterface $fromCurrency, CurrencyInterface $toCurrency, CurrencyRateInterface $default): CurrencyRateInterface
    {
        return $this->repository->find($fromCurrency, $toCurrency, $default);
    }
}
