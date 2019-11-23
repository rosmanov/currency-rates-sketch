<?php
declare(strict_types=1);

namespace App\Database;

interface PreparableSqlDatabaseInterface extends
    DatabaseConnectionInterface,
    SqlDatabaseConnectionInterface,
    PreparableInterface
{
}
