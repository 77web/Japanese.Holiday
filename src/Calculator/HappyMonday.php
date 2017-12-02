<?php


namespace Japanese\Holiday\Calculator;


use Japanese\Holiday\Calculator\Exception\DateNotFoundException;

class HappyMonday implements Calculator
{
    /**
     * @inheritdoc
     */
    public function computeDate($year, array $definition = null)
    {
        $ts = mktime(0, 0, 0, $definition['month'], 1, $year);
        $month = date('F', $ts);
        $firstMondayTs = strtotime('first monday of ' . $month . ' ' . $year);
        if (!$firstMondayTs) {
            throw new DateNotFoundException;
        }
        $date = date('Y-m-d', $firstMondayTs + 60*60*24*7*($definition['seq'] - 1));

        return new \DateTime($date);
    }
} 
