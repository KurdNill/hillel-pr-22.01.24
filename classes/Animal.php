<?php

class Animal
{
    private string $name;

    /**
     * @param string $name
     */
    protected function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    protected function getName(): string
    {
        return $this->name;
    }

    public function sayHi(): string
    {
        return "Hi";
    }
}