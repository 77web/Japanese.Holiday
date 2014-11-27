<?php


namespace Japanese\Holiday\Calculator;


use Japanese\Holiday\Calculator\Exception\DateNotFoundException;

class Autumn implements Calculator
{
    /**
     * @inheritdoc
     */
    public function computeDate($year)
    {
        $autumnDay = false;
        if ($year <= 2099) {
            $autumnDay = floor(23.2488 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        } elseif($year <= 2150) {
            $autumnDay = floor(24.2488 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        }

        if (!$autumnDay) {
            throw new DateNotFoundException;
        }

        return new \DateTime($year.'-09-'.$autumnDay);
    }
} 
