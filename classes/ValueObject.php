<?php

class ValueObject
{
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
    }

    /**
     * @param int $blue
     */
    public function setBlue(int $blue): void
    {
        if ($blue < 0 || $blue > 255) {
            throw new Exception('Color is invalid');
        }
        $this->blue = $blue;
    }

    /**
     * @return int
     */
    public function getBlue(): int
    {
        return $this->blue;
    }

    /**
     * @param int $green
     */
    public function setGreen(int $green): void
    {
        if ($green < 0 || $green > 255) {
            throw new Exception('Color is invalid');
        }
        $this->green = $green;
    }

    /**
     * @return int
     */
    public function getGreen(): int
    {
        return $this->green;
    }

    /**
     * @param int $red
     */
    public function setRed(int $red): void
    {
        if ($red < 0 || $red > 255) {
            throw new Exception('Color is invalid');
        }
        $this->red = $red;
    }

    /**
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    public function equals(ValueObject $obj1, ValueObject $obj2): bool
    {
        if (
            $obj1->getRed() === $obj2->getRed() &&
            $obj1->getGreen() === $obj2->getGreen() &&
            $obj1->getBlue() === $obj2->getBlue()
        ) {
            return true;
        }
        return false;
    }

    public static function random(): ValueObject
    {
        return $color = new ValueObject(
            rand(0, 255),
            rand(0, 255),
            rand(0, 255)
        );
    }

    public function mix(ValueObject $obj): ValueObject
    {
        $obj->setGreen(($this->getGreen() + $obj->getGreen()) / 2);
        $obj->setRed(($this->getRed() + $obj->getRed()) / 2);
        $obj->setBlue(($this->getBlue() + $obj->getBlue()) / 2);
        return $obj;
    }
}