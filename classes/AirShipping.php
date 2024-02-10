<?php

class AirShipping implements Shipping
{
    public function getShippingCost(Order $order): int
    {
        return max(20, $order->getTotalWeight() * 3);
    }
}