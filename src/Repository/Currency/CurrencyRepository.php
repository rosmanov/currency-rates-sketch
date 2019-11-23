<?php
declare(strict_types=1);

namespace App\Repository\Currency;

use App\Collection\BasicCurrencyCollection;
use App\Collection\CurrencyCollectionInterface;
use App\Database\PreparableSqlDatabaseInterface;
use App\Entity\ArrayBasedCurrency;
use App\Entity\CurrencyInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    /**
     * @var PreparableSqlDatabaseInterface
     */
    private $dbConnection;

    /**
     * @param PreparableSqlDatabaseInterface $dbConnection
     */
    public function __construct(
        PreparableSqlDatabaseInterface $dbConnection
    ) {
        $this->dbConnection = $dbConnection;
    }

    /**
     * {@inheritDoc}
     */
    public function findByCode(string $code, CurrencyInterface $default): CurrencyInterface
    {
        static $sql = 'SELECT id, `code`, `symbol`
            FROM `currency`
            WHERE `code` = :code
            LIMIT 1';
        $params = [':code' => $code];

        $row = $this->dbConnection->fetchOne($sql, $params);
        if (!$row) {
            return $default;
        }

        return new ArrayBasedCurrency($row);
    }

    /**
     * {@inheritDoc}
     */
    public function findByCodeArray(array $codes, CurrencyCollectionInterface $default): CurrencyCollectionInterface
    {
        static $sql = 'SELECT id, `code`, `symbol`
            FROM `currency`
            WHERE `code` IN(:code_list)';

        $codeList = array_map([$this->dbConnection, 'escape'], $codes);
        $codeList = implode(',', $codeList);

        $params = [':code_list' => $codeList];

        $rows = $this->dbConnection->fetchAllAssoc($sql, $params);
        if (!$rows) {
            return $default;
        }

        $collection = new BasicCurrencyCollection();
        foreach ($rows as $row) {
            $collection->add(new ArrayBasedCurrency($row));
        }

        return $collection;
    }
}
