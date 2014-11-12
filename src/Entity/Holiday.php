<?php

namespace Japanese\Holiday\Entity;

class Holiday
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param \DateTime $date
     * @param string $name
     */
    public function __construct(\DateTime $date, $name)
    {
        $this->date = $date;
        $this->name = $name;
    }

    /**
     * @param \DateTime $targetDate
     * @return bool
     */
    public function equals(\DateTime $targetDate)
    {
        return $this->date->format('Y-m-d') === $targetDate->format('Y-m-d');
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
