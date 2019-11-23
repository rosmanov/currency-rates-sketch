## About

This is a sketch of a project created for demonstration to specific people.

Again, be warned, the project is not intended for practical use!

## Database

Normally, you would modify the database via some database migration tool. But in this project, for the sake of simplicity, I dumped the database schema and test data to the `database.sql` file.

## Usage

```
<?php
use App\Collection\DummyCurrencyCollection;
use App\Database\DatabaseConnectionInterface;
use App\Database\PdoDatabaseConnection;
use App\Entity\VoidCurrency;
use App\Network\GuzzleNetworkClient;
use App\Network\NetworkClientInterface;
use App\Repository\Currency\CacheCurrencyRateRepository;
use App\Repository\Currency\CbrCacheCurrencyRateRepository;
use App\Repository\Currency\CbrDatabaseCurrencyRateRepository;
use App\Repository\Currency\CurrencyRateRepositoryList;
use App\Repository\Currency\CurrencyRepository;
use App\Repository\Currency\CurrencyRepositoryInterface;
use App\Repository\Currency\DatabaseCurrencyRateRepository;
use App\Repository\Currency\NetworkCurrencyRateRepository;
use App\Strategy\Currency\CbrNetworkFetchDailyStrategy;
use Cache\Adapter\Redis\RedisCachePool;
use GuzzleHttp\Client;

require __DIR__ . '/vendor/autoload.php';

$currencyRepo = getCurrencyRepository();

// Fetch all the required currencies with a single request to database.
$currencies = $currencyRepo->findByCodeArray(
    ['USD', 'RUB'],
    new DummyCurrencyCollection()
);

// Now get the currencies from memory.
$defaultCurrency = new VoidCurrency();
$toCurrency = $currencies->findByCode('USD', $defaultCurrency);
$fromCurrency = $currencies->findByCode('RUB', $defaultCurrency);
// You could also use something like the following, but then you would have to
// make sure to check for count($currencies), at least.
// list('USD' => $toCurrency, 'RUB' => $fromCurrency) = $currencies->asArray();

// Create a sorted list of currency repositories where the fastest goes first.
// A Web-oriented SAPI might want to skip the network repository, and rely on
// CLI process(es) periodically updating the database, and, optionally, the cache.

$repositories = (new CurrencyRateRepositoryList())
    ->append(
        new CbrCacheCurrencyRateRepository(
            new CacheCurrencyRateRepository(getCache())
        )
    )
    ->append(new CbrDatabaseCurrencyRateRepository(
        new DatabaseCurrencyRateRepository(getDatabaseConnection())
    ))
    ->append(
        new NetworkCurrencyRateRepository(
            getNetworkClient(),
            new CbrNetworkFetchDailyStrategy()
        )
    )
;

// The following block might appear in different places such as:
// - Web controller
// - A general-purpose service
// - CLI script running via crontab
// - wherever the user decides to fetch currency rates.
$missingRateStrategy = new RabbitMqScheduleUpdateStrategy(getRabbitMqMessageQueueChannel());
$defaultRate = new VoidCurrencyRate();
$rate = new VoidCurrencyRate();
foreach ($repositories as $repository) {
    $rate = $repository->find($sourceCurrency, $toCurrency, $defaultRate);
    if ($rate->isValid()) {
        break;
    }
    $missingRateStrategy->handle($sourceCurrency, $toCurrency, $repository);

    // Try to find the reverse rate
    $rate = $repository->find($toCurrency, $sourceCurrency, $defaultRate);
    if ($rate->isValid()) {
        // Reverse from reverse is what we really need ;-)
        $rate = new BasicReverseCurrencyRate($rate);
        break;
    }
    $missingRateStrategy->handle($toCurrency, $sourceCurrency, $repository);
}


printf(
    '%s in %s: %.2f (%s)\n',
    $targetRate->targetCurrency()->code(),
    $targetRate->baseCurrency()->code(),
    $targetRate->value(),
    $targetRate->isValid() ? 'valid' : 'invalid'
);

///////////////////////////////////////////////////////////////////////////////
// Utilities.
//
// *Warning*
// Normally, one would create the instances of Redis, PDO et al based on a
// configuration module, bootstrap script etc. Since the implementation of such
// a code highly depends on the project ecosystem (framework), I decided to
// make a set of procedures with a doze of hard-coded settings. I hope you will
// forgive me, and, more importantly, not follow this pattern in your projects.

/**
* @return DatabaseConnectionInterface
* @throws \RuntimeException
*/
function getDatabaseConnection(): DatabaseConnectionInterface
{
    static $connection;

    if ($connection !== null) {
        return $connection;
    }

    try {
        $pdo = new PDO('mysql:dbname=mydb;host=127.0.0.1', 'myuser', 'mypassword');
        $connection = new PdoDatabaseConnection($pdo);
    } catch (\Throwable $e) {
        throw new \RuntimeException(
            'Could not create database connection: ' . $e->getMessage(),
            0,
            $e
        );
    }

    return $connection;
}

function getCurrencyRepository(): CurrencyRepositoryInterface
{
    $dbConnection = getDatabaseConnection();
    return new CurrencyRepository($dbConnection);
}

/**
* @return \Redis
* @throws \RuntimeException
* @note \Redis class is provided by phpredis PECL extension.
*/
function getRedis(): \Redis
{
    static $redis;
    static $socket = '/var/run/redis/redis.sock';

    if ($redis !== null) {
        return $redis;
    }

    $redis = new \Redis();

    if (!$redis->connect($socket)) {
        throw new \RuntimeException('Could not connect to Redis server');
    }

    return $redis;
}

/**
* @return \Psr\Cache\CacheItemPoolInterface
* @throws \RuntimeException
*/
function getCache(): \Psr\Cache\CacheItemPoolInterface
{
    static $cache;

    if ($cache !== null) {
        return $cache;
    }

    $redis = getRedis();
    $cache = new RedisCachePool($redis);
    return $cache;
}

/**
* @return NetworkClientInterface
*/
function getNetworkClient(): NetworkClientInterface
{
    return new GuzzleNetworkClient(new Client([
        'timeout' => 2.0,
    ]));
}
```

In background, instances of different ConsumerInterface implementations are invoked (as daemons, for example.)

## License

MIT (See LICENSE file.)
