<?php
declare(strict_types=1);

namespace App\Database;

/**
 * Semantics for SQL database connectors.
 */
interface SqlDatabaseConnectionInterface
{
    /**
     * Escapes special characters for passing to raw statement
     */
    public function escape(string $string): string;
}
