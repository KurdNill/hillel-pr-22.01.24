<?php

interface Shipping
{
    public function getShippingCost(Order $order): int;
}