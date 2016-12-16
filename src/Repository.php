<?php


namespace Japanese\Holiday;

use Japanese\Holiday\Calculator\Repository as CalculatorRepository;

class Repository
{
    /**
     * @var array
     */
    private $holidayCollection;

    /**
     * @var CalculatorRepository
     */
    private $calculatorRepository;

    /**
     * @param CalculatorRepository $calculatorRepository
     */
    public function __construct(CalculatorRepository $calculatorRepository = null)
    {
        $this->holidayCollection = [];
        $this->calculatorRepository = $calculatorRepository ? $calculatorRepository : $this->createCalculatorRepository();
    }

    /**
     * @param int|null $year
     * @return \Japanese\Holiday\Entity\Holiday[]
     */
    public function getHolidaysForYear($year = null)
    {
        $this->loadHolidaysForYear($year);

        return $this->holidayCollection[$year];
    }

    /**
     * @param string $date
     * @return bool
     */
    public function isHoliday($date)
    {
        $year = date('Y', strtotime($date));
        $this->loadHolidaysForYear($year);

        return isset($this->holidayCollection[$year][$date]);
    }

    /**
     * @param string $date
     * @return \Japanese\Holiday\Entity\Holiday|null
     */
    public function getHoliday($date)
    {
        if ($this->isHoliday($date)) {
            $ts = strtotime($date);
            if ($ts) {
                $year = date('Y', $ts);

                return $this->holidayCollection[$year][$date];
            }
        }
    }

    /**
     * @param string $date
     * @return string|null
     */
    public function getHolidayName($date)
    {
        $holiday = $this->getHoliday($date);

        return $holiday ? $holiday->getName() : null;
    }

    /**
     * @param int $year
     * @param string $caption
     * @return \DateTime|null
     */
    public function getHolidayDate($year, $caption)
    {
        $this->loadHolidaysForYear($year);

        foreach ($this->holidayCollection[$year] as $holiday) {
            /** @var \Japanese\Holiday\Entity\Holiday $holiday */
            if ($holiday->getName() === $caption) {
                return $holiday->getDate();
            }
        }
    }

    /**
     * @return CalculatorRepository
     */
    private function createCalculatorRepository()
    {
        $annualCalculator = new AnnualCalculator();

        return new CalculatorRepository($annualCalculator);
    }

    /**
     * @param int $year
     */
    private function loadHolidaysForYear($year)
    {
        if (!isset($this->holidayCollection[$year])) {
            $this->holidayCollection[$year] = $this->calculatorRepository->find($year)->computeDates($year);
        }
    }
} 
