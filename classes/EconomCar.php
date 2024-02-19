<?php

class EconomCar implements Car
{
    public function showModel(): void
    {
        echo "Lada ";
    }

    public function showPrice(): void
    {
        echo "50грн.\n";
    }
}