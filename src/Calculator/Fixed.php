<?php


namespace Japanese\Holiday\Calculator;


class Fixed implements Calculator
{
    /**
     * @inheritdoc
     */
    public function computeDate($year, array $definition = null)
    {
        return new \DateTime($year.'-'.$definition['month'].'-'.$definition['date']);
    }
} 
