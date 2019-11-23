<?php
declare(strict_types=1);

namespace App\Network;

use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;

class GuzzleNetworkClient implements NetworkClientInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function send(RequestInterface $request, array $options = [])
    {
        return $this->client->send($request, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function sendAsync(RequestInterface $request, array $options = [])
    {
        return $this->client->sendAsync($request, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function request($method, $uri, array $options = [])
    {
        return $this->client->request($method, $uri, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function requestAsync($method, $uri, array $options = [])
    {
        return $this->requestAsync($method, $uri, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig($option = null)
    {
        return $this->client->getConfig($option);
    }
}
