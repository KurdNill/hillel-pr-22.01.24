<?php

class GroundShipping implements Shipping
{
    public function getShippingCost(Order $order): int
    {
        return $order->getTotal() > 100 ? 0 : max(10, $order->getTotalWeight());
    }
}