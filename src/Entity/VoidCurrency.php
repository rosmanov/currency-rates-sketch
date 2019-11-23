<?php
declare(strict_types=1);

namespace App\Entity;

/**
 * Represents the absence of currency entitiy.
 *
 * Can be used as a sentinel, or a replacement for the NULL value.
 */
final class VoidCurrency implements CurrencyInterface
{
    /**
     * {@inheritDoc}
     */
    public function id(): int
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function code(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function symbol(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize([]);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        // Do nothing
    }
}
