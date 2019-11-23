<?php
declare(strict_types=1);

namespace App\Strategy\Currency;

use App\Network\NetworkClientInterface;
use Psr\Http\Message\ResponseInterface;

interface NetworkFetchDailyStrategyInterface
{
    /**
     * @param NetworkClientInterface $client
     * @param \DateTimeImmutable $dateTime
     *
     * @return ResponseInterface
     *
     * @throws \RuntimeException
     *
     * XXX We might parse the response and return some kind of DTO instead.
     */
    public function fetch(NetworkClientInterface $client, \DateTimeImmutable $dateTime): ResponseInterface;
}
