<?php


namespace Japanese\Holiday\Calculator\Exception;


class DateNotFoundException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('該当する年月日が算出できません（定義が誤っています）');
    }
} 
