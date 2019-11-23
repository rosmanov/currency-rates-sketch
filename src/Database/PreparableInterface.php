<?php
declare(strict_types=1);

namespace App\Database;

interface PreparableInterface
{
    /**
     * @param string $statement
     * @return bool
     */
    public function prepare(string $statement): bool;

    /**
     * @param array $params Key-value pairs to bind to the statement
     *
     * @return bool
     */
    public function executePrepared(array $params): bool;

    /**
     * Fetches associative array of rows according to the previously executed
     * statement (see executePrepared method).
     *
     * @return array Associative array
     */
    public function fetchAllAssocPrepared(): array;

    /**
     * Shortcut for executePrepared() + fetchAllAssocPrepared()
     *
     * @return array Associative array
     */
    public function fetchAllAssoc(string $statement, array $params): array;

    /**
     * Fetches single row as associative array
     *
     * @return array
     */
    public function fetchOne(string $statement, array $params): array;
}
