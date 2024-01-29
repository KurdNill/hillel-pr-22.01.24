<?php

class Cat extends Animal
{
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function sayHi(): string
    {
        return parent::sayHi() . ", my name is " . $this->getName();
    }
}