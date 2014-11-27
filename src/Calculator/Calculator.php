<?php


namespace Japanese\Holiday\Calculator;

use Japanese\Holiday\Calculator\Exception\DateNotFoundException;

interface Calculator
{
    /**
     * @param int $year
     * @return \DateTime
     * @throws DateNotFoundException
     */
    public function computeDate($year);
}
