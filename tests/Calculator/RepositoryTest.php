<?php


namespace Japanese\Holiday\Calculator;


class RepositoryTest extends \PHPUnit_Framework_TestCase 
{
    public function test_find()
    {
        $defaultCalculator = $this->getMockBuilder('\Japanese\Holiday\AnnualCalculator')->disableOriginalConstructor()->getMock();

        $repository = new Repository($defaultCalculator, __DIR__.'/../data');

        $calculator2014 = $repository->find(2014);
        $this->assertInstanceOf('\Japanese\Holiday\PastCalculator', $calculator2014);

        $calculator2015 = $repository->find(2015);
        $this->assertInstanceOf('\Japanese\Holiday\AnnualCalculator', $calculator2015);
    }
}
