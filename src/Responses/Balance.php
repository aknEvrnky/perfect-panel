<?php

namespace AknEvrnky\PerfectPanel\Responses;

class Balance
{
    public function __construct(private float $balance, private string $currency)
    {
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }


    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}