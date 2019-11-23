<?php
declare(strict_types=1);

namespace App\Contract;

/**
 * An object having a numeric identifier.
 */
interface NumericIdentifiableInterface extends IdentifiableInterface
{
    /**
     * {@inheritDoc}
     */
    public function id(): int;
}
