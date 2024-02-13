<?php

class EconomTaxi extends TypeOfDelivery
{
    public function getType(): Car
    {
        return new EconomCar;
    }
}