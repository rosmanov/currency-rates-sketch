<?php
declare(strict_types=1);

namespace App\Repository\Currency;

use App\Database\PreparableSqlDatabaseInterface;
use App\Entity\BasicCurrencyRate;
use App\Entity\CurrencyInterface;
use App\Entity\CurrencyRateInterface;

class DatabaseCurrencyRateRepository implements CurrencyRateRepositoryInterface
{
    /**
     * @var PreparableSqlDatabaseInterface
     */
    private $connection;

    /**
     * @var int
     */
    private $scope = 0;


    public function __construct(PreparableSqlDatabaseInterface $connection, int $scope = 0)
    {
        $this->connection = $connection;
        $this->scope = $scope;
    }

    public function withScope(int $scope): self
    {
        $object = clone $this;
        $object->scope = $scope;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function find(CurrencyInterface $fromCurrency, CurrencyInterface $toCurrency, CurrencyRateInterface $default): CurrencyRateInterface
    {
        $row = $this->connection->fetchOne(
            'SELECT rate
            FROM currency_rate
            WHERE from_currency_id = :from_currency_id
                AND to_currency_id = :to_currency_id
                AND scope_id = :scope_id',
            [
                ':from_currency_id' => $fromCurrency->id(),
                ':to_currency_id' => $toCurrency->id(),
                ':scope_id' => $this->scope,
            ]
        );

        if (!$row) {
            return $default;
        }

        return new BasicCurrencyRate($toCurrency, $fromCurrency, (float)$row['rate']);
    }
}
