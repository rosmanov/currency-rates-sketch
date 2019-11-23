<?php
declare(strict_types=1);

namespace App\Entity;

use App\Contract\NumericIdentifiableInterface;
use App\Contract\ValidStateContainerInterface;

interface CurrencyInterface extends
    NumericIdentifiableInterface,
    ValidStateContainerInterface,
    \Serializable // for sending to the message queues
{
    /**
     * Returns currency code such as USD, RUB etc.
     *
     * @return string
     */
    public function code(): string;

    /**
     * Returns international currency symbol in UTF-8
     *
     * @return string
     */
    public function symbol(): string;
}
