<?php

class ByEmail implements Deliver
{
    public function getDelivery(string $format): void
    {
        echo "Вывод формата ({$format}) по имейл";
    }
}