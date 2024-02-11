<?php

class Raw implements Format
{
    public function getFormat(string $string): string
    {
        return $string;
    }
}