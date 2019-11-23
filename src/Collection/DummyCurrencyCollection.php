<?php
declare(strict_types=1);

namespace App\Collection;

class DummyCurrencyCollection implements CurrencyCollectionInterface
{
    /**
     * {@inheritDoc}
     */
    public function add(CurrencyInterface $currency): CurrencyCollectionInterface
    {
        // Dummy collection should stay dummy, so don't do anything.
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clear(): CurrencyCollectionInterface
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function asArray(): array
    {
        return [];
    }
}
