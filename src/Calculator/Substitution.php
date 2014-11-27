<?php


namespace Japanese\Holiday\Calculator;


class Substitution implements Calculator
{
    /**
     * @inheritdoc
     */
    public function computeDate($year, array $definition = null)
    {
        /** @var \DateTime $date */
        $date = clone $definition['holiday_at_sunday'];

        return $date->add(new \DateInterval('P'.$definition['offset'].'D'));
    }
} 
