<?php

class ToConsole implements Deliver
{
    public function getDelivery(string $format): void
    {
        echo "Вывод формата ({$format}) в консоль";
    }
}
