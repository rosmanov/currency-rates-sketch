<?php
declare(strict_types=1);

namespace App\Repository\Currency;

use App\Entity\CurrencyInterface;
use App\Entity\CurrencyRateInterface;
use App\Entity\VoidCurrencyRate;
use App\Network\NetworkClientInterface;
use App\Strategy\Currency\NetworkFetchDailyStrategyInterface;

class NetworkCurrencyRateRepository implements CurrencyRateRepositoryInterface
{
    /**
     * @var NetworkClientInterface
     */
    private $client;

    /**
     * @var NetworkFetchDailyStrategyInterface
     */
    private $fetchStrategy;


    public function __construct(
        NetworkClientInterface $client,
        NetworkFetchDailyStrategyInterface $fetchStrategy
    ) {
        $this->client = $client;
        $this->fetchStrategy = $fetchStrategy;
    }

    /**
     * {@inheritDoc}
     */
    public function find(CurrencyInterface $fromCurrency, CurrencyInterface $toCurrency, CurrencyRateInterface $default): CurrencyRateInterface
    {
        $response = $this->fetchStrategy->fetch($this->client, new \DateTimeImmutable());

        // XXX parse response and return an instance of *CurrencyRate

        return new VoidCurrencyRate();
    }
}
