<?php

abstract class TypeOfDelivery
{
    abstract public function getType(): Car;
    public function getCar(): void
    {
        $car = $this->getType();
        $car->showModel();
        $car->showPrice();
    }
}