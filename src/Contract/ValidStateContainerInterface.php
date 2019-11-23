<?php
declare(strict_types=1);

namespace App\Contract;

/**
 * Support for a method returning a boolean value depending on whether the
 * object is in valid, or invalid state.
 */
interface ValidStateContainerInterface
{
    /**
     * Returns TRUE, if the object is in valid state.
     *
     * @return bool
     */
    public function isValid(): bool;
}
