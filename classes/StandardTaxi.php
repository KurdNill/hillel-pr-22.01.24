<?php

class StandardTaxi extends TypeOfDelivery
{
    public function getType(): Car
    {
        return new StandardCar;
    }
}