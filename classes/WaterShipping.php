<?php

class WaterShipping implements Shipping
{
    public function getShippingCost(Order $order): int
    {
        return $order->getTotal() > 100 ? max(10, $order->getTotalWeight()) :
            max(15, $order->getTotalWeight() * 2);
    }
}