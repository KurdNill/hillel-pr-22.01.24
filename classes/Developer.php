<?php

class Developer implements Employee
{
    public function doJob(): void
    {
        echo __CLASS__ . ": Write code \n";
    }

}