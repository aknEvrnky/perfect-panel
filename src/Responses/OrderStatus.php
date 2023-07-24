<?php

namespace AknEvrnky\PerfectPanel\Responses;

class OrderStatus
{
    private int $id;
    private float $charge;
    private int $start_count;
    private string $status;
    private int $remains;
    private string $currency;


    public function __construct(int $id, float $charge, int $start_count, string $status, int $remains, string $currency)
    {
        $this->id = $id;
        $this->charge = $charge;
        $this->start_count = $start_count;
        $this->status = $status;
        $this->remains = $remains;
        $this->currency = $currency;
    }

    public static function fromArray(array $data): OrderStatus
    {
        return new OrderStatus(
            $data['id'],
            $data['charge'],
            $data['start_count'],
            $data['status'],
            $data['remains'],
            $data['currency']
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return float
     */
    public function getCharge(): float
    {
        return $this->charge;
    }


    /**
     * @return int
     */
    public function getStartCount(): int
    {
        return $this->start_count;
    }


    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }


    /**
     * @return int
     */
    public function getRemains(): int
    {
        return $this->remains;
    }


    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

}