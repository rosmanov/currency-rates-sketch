<?php
declare(strict_types=1);

namespace App\Database;

/**
 * @todo Consider logging (inject LoggerInterface?)
 */
class PdoDatabaseConnection extends PreparableSqlDatabaseInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement|null
     */
    private $preparedStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * {@inheritDoc}
     *
     * @todo save affected rows/error
     */
    public function exec(string $statement): void
    {
        $this->pdo->exec($statement);
    }

    /**
     * {@inheritDoc}
     *
     * @todo add similar methods for different PDO parameter types,
     * or provide parameter flags similar to those in PDO class.
     */
    public function escape(string $string): string
    {
        return $this->pdo->quote($string);
    }

    public function query(string $statement): \Traversable
    {
        return $this->pdo->query($statement);
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(string $statement): bool
    {
        $this->preparedStatement = $this->pdo->prepare($statement);
        return (bool) $this->preparedStatement;
    }

    /**
     * {@inheritDoc}
     */
    public function executePrepared(array $params): bool
    {
        if ($this->preparedStatement) {
            return $this->preparedStatement->execute($params);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAllAssocPrepared(): array
    {
        return $this->preparedStatement->fetchAll();
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAllAssoc(string $statement, array $params): array
    {
        if (!$this->prepare($statement)) {
            return [];
        }

        if (!$this->executePrepared($params)) {
            return [];
        }

        return $this->fetchAllAssocPrepared();
    }

    /**
     * {@inheritDoc}
     */
    public function fetchOne(string $statement, array $params): array
    {
        if (!$this->prepare($statement)) {
            return [];
        }

        if (!$this->executePrepared($params)) {
            return [];
        }

        return $this->preparedStatement->fetch();
    }
}
