<?php

class BySms implements Deliver
{
    public function getDelivery(string $format): void
    {
        echo "Вывод формата ({$format}) в смс";
    }
}