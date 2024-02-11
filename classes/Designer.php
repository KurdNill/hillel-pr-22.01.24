<?php

class Designer implements Employee
{
    public function doJob(): void
    {
        echo __CLASS__ . ": Create Architecture \n";
    }

}