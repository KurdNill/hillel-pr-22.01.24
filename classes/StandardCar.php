<?php

class StandardCar implements Car
{
    public function showModel(): void
    {
        echo "BMW ";
    }

    public function showPrice(): void
    {
        echo "100грн.\n";
    }
}