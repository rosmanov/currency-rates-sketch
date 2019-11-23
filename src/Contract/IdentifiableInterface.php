<?php
declare(strict_types=1);

namespace App\Contract;

/**
 * An object having an identifier of any data type.
 */
interface IdentifiableInterface
{
    /**
     * Returns the object identifier
     *
     * @return mixed
     */
    public function id();
}
