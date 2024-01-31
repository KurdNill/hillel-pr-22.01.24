<?php


class Test
{
    use Trait1, Trait2, Trait3 {
        Trait1::test insteadof Trait2;
        Trait1::test insteadof Trait3;
        Trait2::test as test2;
        Trait3::test as test3;
    }

    public function getSum(): int
    {
        return $this->test() + $this->test2() + $this->test3();
    }
}