<?php

class Tester implements Employee
{
    public function doJob(): void
    {
        echo __CLASS__ . ": Make test \n";
    }

}