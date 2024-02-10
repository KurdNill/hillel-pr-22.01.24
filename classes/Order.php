<?php

class Order
{
    protected Shipping $shipping;
    protected int $total, $weight;
    public function setTotal(): void
    {
        $this->total = rand(50, 200);
    }

    public function setTotalWeight(): void
    {
        $this->weight = rand(1, 25);
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        return $this->weight;
    }

    public function setShippingType(Shipping $type): void
    {
        $this->shipping = $type;
    }

    /**
     * @return string
     */
    public function getShippingCost(): int
    {
        return $this->shipping->getShippingCost($this);
    }
}