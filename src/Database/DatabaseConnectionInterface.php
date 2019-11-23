<?php
declare(strict_types=1);

namespace App\Database;

/**
 * @todo Add the rest of PDO features
 */
interface DatabaseConnectionInterface
{
    /**
     * Executes a raw statement
     */
    public function exec(string $statement): void;

    public function query(string $statement): \Traversable;
}
