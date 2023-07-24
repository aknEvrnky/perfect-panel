<?php

namespace Tests;

use AknEvrnky\PerfectPanel\Client\PerfectPanel;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public PerfectPanel $perfectPanel;

    public function mockGuzzleWithData(array $data): void
    {

        $mock = new MockHandler([
            new Response(200, [], json_encode($data)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->perfectPanel = new PerfectPanel('http://api.example.com', 'api-key');
        $this->perfectPanel->setClient($client);
    }
}
