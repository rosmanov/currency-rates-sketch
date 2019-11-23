<?php
declare(strict_types=1);

namespace App\MessageQueue\Consumer;

interface ConsumerInterface
{
    public function handle($message): void;
}
