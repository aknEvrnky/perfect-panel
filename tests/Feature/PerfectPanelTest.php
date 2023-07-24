<?php

use AknEvrnky\PerfectPanel\Exceptions\ApiErrorException;
use AknEvrnky\PerfectPanel\Responses\Balance;
use AknEvrnky\PerfectPanel\Responses\OrderStatus;
use AknEvrnky\PerfectPanel\Responses\Service;
use Illuminate\Support\Collection;

it('fetches services', function () {
    $this->mockGuzzleWithData([
        [
            'service' => 1,
            'name' => 'Followers',
            'type' => 'Default',
            'category' => 'First Category',
            'rate' => '0.90',
            'min' => '50',
            'max' => '10000',
            'refill' => true,
            'cancel' => true,
        ],
        [
            'service' => 2,
            'name' => 'Comments',
            'type' => 'Custom Comments',
            'category' => 'Second Category',
            'rate' => '8',
            'min' => '10',
            'max' => '1500',
            'refill' => false,
            'cancel' => true,
        ],

    ]);

    $services = $this->perfectPanel->services();

    expect($services)->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->and($services->first())->toBeInstanceOf(Service::class)
        ->and($services->first()->getName())->toBe('Followers');
});

it('creates an order', function () {
    $this->mockGuzzleWithData([
        'order' => 23501,
    ]);
    $orderId = $this->perfectPanel->order(2, 'http://example.com', 100);
    // Assert that the order ID is returned correctly
    expect($orderId)->toBe(23501);
});

it('fetches the balance', function () {
    $this->mockGuzzleWithData([
        'balance' => 100.00,
        'currency' => 'USD',
    ]);
    $balance = $this->perfectPanel->balance();
    // Assert that the balance is returned correctly
    expect($balance)->toBeInstanceOf(Balance::class)
        ->and($balance->getBalance())->toBe(100.00)
        ->and($balance->getCurrency())->toBe('USD');
});

it('fetches the status of an order', function () {
    $this->mockGuzzleWithData([
        'charge' => '0.90',
        'start_count' => '0',
        'status' => 'In Progress',
        'remains' => '10000',
        'currency' => 'USD',
    ]);

    $status = $this->perfectPanel->status(23501);
    // Assert that the status is returned correctly
    expect($status)->toBeInstanceOf(OrderStatus::class)
        ->and($status->getCharge())->toBe(0.90)
        ->and($status->getStartCount())->toBe(0)
        ->and($status->getStatus())->toBe('In Progress')
        ->and($status->getRemains())->toBe(10000)
        ->and($status->getCurrency())->toBe('USD');
});

it('fetches the status of multiple orders', function () {
    $this->mockGuzzleWithData([
        '1' => [
            'charge' => '0.27819',
            'start_count' => '3572',
            'status' => 'Partial',
            'remains' => '157',
            'currency' => 'USD',
        ],
        '10' => [
            'error' => 'Incorrect order ID',
        ],
        '100' => [
            'charge' => '1.44219',
            'start_count' => '234',
            'status' => 'In progress',
            'remains' => '10',
            'currency' => 'USD',
        ],
    ]);

    $this->expectException(ApiErrorException::class);

    $statuses = $this->perfectPanel->statuses([1, 10, 100]);

    expect($statuses)->toBeInstanceOf(Collection::class)
        ->toHaveCount(3)
        ->and($statuses[0])->toBeInstanceOf(OrderStatus::class)
        ->and($statuses[0]->getStatus())->toBe('Partial');
});

it('creates a refill', function () {
    $this->mockGuzzleWithData([
        'refill' => '1',
    ]);

    $refillId = $this->perfectPanel->refill(23501);

    expect($refillId)->toBe(1);
});

it('fetches the status of a refill', function () {
    $this->mockGuzzleWithData([
        'status' => 'Completed',
    ]);

    $status = $this->perfectPanel->refillStatus(1);

    expect($status)->toBe('Completed');
});