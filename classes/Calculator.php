<?php

class Calculator
{
    const ZERO_VALUE = 0;
    protected float $result;

    public function __construct(
        public float $number1 = 0,
        public float $number2 = 0
    ){ }

    public function plus()
    {
        $this->result = $this->number1 + $this->number2;
    }

    public function minus()
    {
        $this->result = $this->number1 - $this->number2;
    }

    public function division()
    {
        if (self::ZERO_VALUE == $this->number2) {
            throw new Exception('We can not divide on zero');
        }
        $this->result = $this->number1 / $this->number2;
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return $this->result;
    }
}