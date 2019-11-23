<?php

declare(strict_types=1);

namespace App\Repository\Currency;

use App\Entity\BasicCurrencyRate;
use App\Entity\CurrencyInterface;
use App\Entity\CurrencyRateInterface;
use Psr\Cache\CacheItemPoolInterface;

class CacheCurrencyRateRepository implements CurrencyRateRepositoryInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var string
     */
    private $scope;

    /**
     * @param CacheItemPoolInterface $cache
     * @param string $scope
     */
    public function __construct(CacheItemPoolInterface $cache, string $scope = '')
    {
        $this->cache = $cache;
        $this->scope = $scope;
    }

    public function withScope(string $scope): self
    {
        $object = clone $this;
        $object->scope = $scope;
        return $object;
    }

    private function getKey(CurrencyInterface $toCurrency, CurrencyInterface $fromCurrency): string
    {
        return sprintf(
            '%s:%s:%s',
            $this->scope,
            $toCurrency->code(),
            $fromCurrency->code()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function find(CurrencyInterface $fromCurrency, CurrencyInterface $toCurrency, CurrencyRateInterface $default): CurrencyRateInterface
    {
        $key = $this->getKey($toCurrency, $fromCurrency);

        $item = $this->cache->getItem($key);
        if (!$item->isHit()) {
            return $default;
        }

        $value = $item->get();
        if ($value === null || !is_numeric($value)) {
            // XXX log (and remove)?
            return $default;
        }
        $value = floatval($value);

        return new BasicCurrencyRate($toCurrency, $fromCurrency, $value);
    }
}
