<?php
declare(strict_types=1);

namespace App\Strategy\Currency;

use App\Network\NetworkClientInterface;
use Psr\Http\Message\ResponseInterface;

class CbrNetworkFetchDailyStrategy implements NetworkFetchDailyStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function fetch(NetworkClientInterface $client, \DateTimeImmutable $dateTime): ResponseInterface
    {
        $dateReq = $dateTime->format('%d/%m/%Y');
        $uri = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $dateReq;

        try {
            return $client->request('GET', $uri);
        } catch (\Throwable $e) {
            throw new \RuntimeException($e->getMessage(), 0, $e);
        }
    }
}
