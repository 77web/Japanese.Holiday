<?php


namespace Japanese\Holiday\Calculator;


use Japanese\Holiday\Calculator\Exception\DateNotFoundException;

class Spring implements Calculator
{
    /**
     * @inheritdoc
     */
    public function computeDate($year)
    {
        $springDay = false;
        if ($year <= 2099) {
            $springDay = floor(20.8431 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        } elseif ($year <= 2150) {
            $springDay = floor(21.8510 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        }

        if (!$springDay) {
            throw new DateNotFoundException;
        }

        return new \DateTime($year.'-03-'.$springDay);
    }
} 
