<?php
declare(strict_types=1);

namespace App\Collection;

use App\Entity\CurrencyInterface;

/**
 * Collection of CurrencyInterface
 */
interface CurrencyCollectionInterface extends \Traversable, \Countable
{
    /**
     * Adds a currency to the collection
     *
     * @param CurrencyInterface $currency
     * @return self
     */
    public function add(CurrencyInterface $currency): self;

    /**
     * Removes all items from the collection
     *
     * @return self
     */
    public function clear(): self;

    /**
     * @param string $code Currency code such as USD, RUB etc.
     * @param CurrencyInterface $default
     *
     * @return CurrencyInterface
     */
    public function findByCode(string $code, CurrencyInterface $default): CurrencyInterface;

    /**
     * Returns array representation of the collection
     *
     * @return CurrencyInterface[]
     */
    public function asArray(): array;
}
