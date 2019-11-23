<?php
declare(strict_types=1);

namespace App\Repository\Currency;

use App\Entity\CurrencyInterface;
use App\Entity\CurrencyRateInterface;

class CbrCacheCurrencyRateRepository implements CurrencyRateRepositoryInterface
{
    private const CBR_SCOPE = 'CBR';

    /**
     * @var CacheCurrencyRateRepository
     */
    private $cacheRepo;

    public function __construct(CacheCurrencyRateRepository $cacheRepo)
    {
        $this->cacheRepo = $cacheRepo->withScope(self::CBR_SCOPE);
    }

    /**
     * {@inheritDoc}
     */
    public function find(CurrencyInterface $fromCurrency, CurrencyInterface $toCurrency, CurrencyRateInterface $default): CurrencyRateInterface
    {
        return $this->cacheRepo->find($fromCurrency, $toCurrency, $default);
    }
}
