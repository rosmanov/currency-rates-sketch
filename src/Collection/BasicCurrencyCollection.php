<?php
declare(strict_types=1);

namespace App\Collection;

use App\Entity\CurrencyInterface;

class BasicCurrencyCollection implements
    CurrencyCollectionInterface,
    \IteratorAggregate
{
    /**
     * @var CurrencyInterface[]
     */
    private $currencies = [];

    /**
     * {@inheritDoc}
     */
    public function add(CurrencyInterface $currency): CurrencyCollectionInterface
    {
        $this->currencies[$currency->code()] = $currency;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clear(): CurrencyCollectionInterface
    {
        $this->currencies = [];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function asArray(): array
    {
        return $this->currencies;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->currencies);
    }

    /**
     * {@inheritDoc}
     */
    public function findByCode(string $code, CurrencyInterface $default): CurrencyInterface
    {
        return $this->currencies[$code] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->currencies);
    }
}
