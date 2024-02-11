<?php

class WithDate implements Format
{
    public function getFormat(string $string): string
    {
        return date('Y-m-d H:i:s') . " $string";
    }
}