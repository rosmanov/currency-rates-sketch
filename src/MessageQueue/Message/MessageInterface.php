<?php
declare(strict_types=1);

namespace App\MessageQueue\Message;

interface MessageInterface extends \Serializable
{
    public function toString(): string;
}
