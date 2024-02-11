<?php

class Manager implements Employee
{
    public function doJob(): void
    {
        echo __CLASS__ . ": Make work \n";
    }

}