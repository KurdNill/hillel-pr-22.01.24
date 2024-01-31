<?php

class User
{
    private string $name = '';
    private int $age = 0;
    private string $email = '';

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $age
     */
    private function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    private function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    private function getAge(): int
    {
        return $this->age;
    }

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        throw new Exception('The method doesn`t exists');
    }

    public function getAll(): array
    {
        return [$this->name, $this->age, $this->email];
    }
}