<?php

class LuxeTaxi extends TypeOfDelivery
{
    public function getType(): Car
    {
        return new LuxeCar;
    }
}