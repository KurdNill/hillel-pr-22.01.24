<?php

class Logger
{
    private Format $format;
    private Deliver $delivery;

    public function __construct(Format $format, Deliver $delivery)
    {
        $this->format = $format;
        $this->delivery = $delivery;
    }

    public function log(string $string): void
    {
        $this->deliver($this->format($string));
    }

    public function format(string $string): string
    {
        return $this->format->getFormat($string);
    }

    public function deliver(string $format): void
    {
        $this->delivery->getDelivery($format);
    }

}