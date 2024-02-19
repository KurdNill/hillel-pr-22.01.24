<?php

class LuxeCar implements Car
{
    public function showModel(): void
    {
        echo "Bugatti ";
    }

    public function showPrice(): void
    {
        echo "1000грн.\n";
    }
}