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

    /*
        Валідацію краще винести в окремий метод, бо вона використовується тричі,
        щоб не дублювати код, краще таке мати в окремому методі :)
    */
    protected function validate(int $color)
    {
        if ($color < 0 || $color > 255) {
            throw new Exception('Color is invalid');
        }
    }
    
    /**
     * @param int $blue
     */
    public function setBlue(int $blue): void
    {
        $this->validate($blue);
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
        $this->validate($green);
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
        $this->validate($red);
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
        // if (
            // $obj1->getRed() === $obj2->getRed() &&
            // $obj1->getGreen() === $obj2->getGreen() &&
            // $obj1->getBlue() === $obj2->getBlue()
        // ) {
        //     return true;
        // }
        // return false;

        // Тут можна простіше
        return $obj1->getRed() === $obj2->getRed() && $obj1->getGreen() === $obj2->getGreen() && $obj1->getBlue() === $obj2->getBlue();
    }

    public static function random(): ValueObject
    {
        // $color = не потрібно
        // return $color = new ValueObject(
        //     rand(0, 255),
        //     rand(0, 255),
        //     rand(0, 255)
        // );
        
        return new ValueObject(
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
