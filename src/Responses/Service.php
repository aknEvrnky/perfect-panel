<?php

namespace AknEvrnky\PerfectPanel\Responses;

class Service
{
    private string $rate;
    private string $service;
    private string $category;
    private string $name;
    private string $type;
    private string $min;
    private string $max;
    private string $description;
    private bool $refill;
    private bool $cancel;


    public function __construct()
    {

    }


    public static function fromArray(array $data): Service
    {
        $service = new Service();
        if (isset($data['rate'])) {
            $service->setRate($data['rate']);
        }
        if (isset($data['service'])) {
            $service->setService($data['service']);
        }
        if (isset($data['category'])) {
            $service->setCategory($data['category']);
        }
        if (isset($data['name'])) {
            $service->setName($data['name']);
        }
        if (isset($data['type'])) {
            $service->setType($data['type']);
        }
        if (isset($data['min'])) {
            $service->setMin($data['min']);
        }
        if (isset($data['max'])) {
            $service->setMax($data['max']);
        }
        if (isset($data['description'])) {
            $service->setDescription($data['description']);
        }
        if (isset($data['refill'])) {
            $service->setDescription($data['refill']);
        }
        if (isset($data['cancel'])) {
            $service->setDescription($data['cancel']);
        }

        return $service;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMin(): string
    {
        return $this->min;
    }

    /**
     * @return string
     */
    public function getMax(): string
    {
        return $this->max;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $rate
     */
    public function setRate(string $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $min
     */
    public function setMin(string $min): void
    {
        $this->min = $min;
    }

    /**
     * @param string $max
     */
    public function setMax(string $max): void
    {
        $this->max = $max;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isRefill(): bool
    {
        return $this->refill;
    }

    /**
     * @param bool $refill
     */
    public function setRefill(bool $refill): void
    {
        $this->refill = $refill;
    }

    /**
     * @return bool
     */
    public function isCancel(): bool
    {
        return $this->cancel;
    }

    /**
     * @param bool $cancel
     */
    public function setCancel(bool $cancel): void
    {
        $this->cancel = $cancel;
    }


}