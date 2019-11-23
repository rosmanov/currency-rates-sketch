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
     *
     * @param string $statement
     */
    public function exec(string $statement): void;

    /**
     * Executes a raw statement and returns the result set
     *
     * @param string $statement
     */
    public function query(string $statement): \Traversable;
}
