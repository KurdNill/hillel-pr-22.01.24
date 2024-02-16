<?php

class Contact
{
    private string $phone;
    private string $name;
    private string $surname;
    private string $email;
    private string $address;
    private string $build;

    public function __construct()
    {
        $this->build = date('d F Y H:i:s');
    }

    public function phone(string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    public function name(string $name): Contact
    {
        $this->name = $name;
        return $this;
    }

    public function surname(string $surname): Contact
    {
        $this->surname = $surname;
        return $this;
    }

    public function email(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    public function address(string $address): Contact
    {
        $this->address = $address;
        return $this;
    }

    public function build(): Contact
    {
        return $this;
    }
}