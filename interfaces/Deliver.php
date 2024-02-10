<?php

interface Deliver
{
    public function getDelivery(string $format): void;
}