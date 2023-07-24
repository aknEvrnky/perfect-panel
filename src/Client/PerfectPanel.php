<?php

namespace AknEvrnky\PerfectPanel\Client;

use AknEvrnky\PerfectPanel\Exceptions\ApiErrorException;
use AknEvrnky\PerfectPanel\Responses\Balance;
use AknEvrnky\PerfectPanel\Responses\OrderStatus;
use AknEvrnky\PerfectPanel\Responses\Service;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class PerfectPanel
{
    private Client $client;

    /**
     * @param string $apiUri
     * @param string $apiKey
     */
    public function __construct(protected string $apiUri, protected string $apiKey)
    {
        $this->client = new Client([
            'base_uri' => $this->apiUri,
            'timeout' => 30,
        ]);

    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * Returns a collection of available services
     *
     * @return Collection<int, Service>
     * @throws GuzzleException|ApiErrorException
     */
    public function services(): Collection
    {
        $response = $this->client->post('', [
            'form_params' => [
                'key' => $this->apiKey,
                'action' => 'services',
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        static::validateResponseBody($body);

        return (new Collection($body))->mapWithKeys(fn($service) => [(int) $service['service'] => Service::fromArray($service)]);
    }


    /**
     * Creates an order. Returns the order ID.
     *
     * @param string|int $service
     * @param string $link
     * @param int $quantity
     * @return int
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function order(string|int $service, string $link, int $quantity): int
    {
        $response = $this->client->post('', [
            'form_params' => [
                'key' => $this->apiKey,
                'action' => 'add',
                'service' => $service,
                'link' => $link,
                'quantity' => $quantity,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        static::validateResponseBody($body);

        return (int) $body['order'];
    }


    /**
     * Returns the status of an order.
     *
     * @param int $orderID
     * @return OrderStatus
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function status(int $orderID): OrderStatus
    {
        $response = $this->client->post('', [
            'form_params' => [
                'key' => $this->apiKey,
                'action' => 'status',
                'order' => $orderID,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        static::validateResponseBody($body);
        $body['id'] = $orderID;

        return OrderStatus::fromArray($body);
    }

    /**
     * Returns the status of multiple orders.
     *
     * @param array|string $orders
     * @return Collection
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function statuses(array|string $orders): Collection
    {
        if (is_array($orders))
            $orders = join(',', $orders);

        $response = $this->client->post('', [
            'form_params' => [
                'key' => $this->apiKey,
                'action' => 'status',
                'orders' => $orders,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        if ($body !== null) {
            foreach ($body as $item) {
                static::validateResponseBody($item);
            }
        }

        return (new Collection($body))
            ->mapWithKeys(function ($order, $orderID) {
                $order['id'] = $orderID;
                return [$orderID => OrderStatus::fromArray($order)];
            });
    }

    private static function validateResponseBody(?array $body): void
    {
        if ($body === null)
            throw new ApiErrorException;

        if (isset($body['error']) && $body['error'])
            throw new ApiErrorException($body['error']);
    }

    /**
     * Returns the balance of your account.
     * @return Balance
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function balance(): Balance
    {
        $response = $this->client->post('', [
            'form_params' => [
                'key' => $this->apiKey,
                'action' => 'balance',
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        static::validateResponseBody($body);

        return new Balance($body['balance'], $body['currency']);
    }

    /**
     * Refills order's quantity.
     *
     * @param int $orderID
     * @return int
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function refill(int $orderID): int
    {
        $response = $this->client->post('', [
            'form_params' => [
                'key' => $this->apiKey,
                'action' => 'refill',
                'order' => $orderID,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        static::validateResponseBody($body);

        return $body['refill'];
    }

    /**
     * Returns the status of a refill.
     *
     * @param int $refillID
     * @return string
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function refillStatus(int $refillID): string
    {
        $response = $this->client->post('', [
            'form_params' => [
                'key' => $this->apiKey,
                'action' => 'refill_status',
                'refill' => $refillID,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        static::validateResponseBody($body);

        return $body['status'];
    }
}