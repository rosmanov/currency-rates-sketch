<?php
declare(strict_types=1);

namespace App\Repository\Currency;

/**
 * Traversable list of currency rate repositories.
 */
class CurrencyRateRepositoryList implements \IteratorAggregate
{
    /**
     * @var CurrencyRateRepositoryInterface[]
     */
    private $repositories = [];

    /**
     * Appends the specified repository to the end of the list.
     */
    public function append(CurrencyRateRepositoryInterface $repository): self
    {
        $this->repositories[] = $repository;
        return $this;
    }

    /**
     * Removes all repositories
     */
    public function clear(): self
    {
        $this->repositories = [];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->repositories);
    }
}
