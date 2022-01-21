<?php

namespace ActivityTimetable\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class WeekOfWork
{
    /**
     * @JMS\Type("ArrayCollection<ActivityTimetable\Domain\DayOfWork>")
     * @JMS\Groups({"weeksOfWork"})
     */
    protected $dayOfWorks;

    /**
     * @JMS\Type("integer")
     * @JMS\Groups({"weeksOfWork"})
     */
    protected $week;

    public function __construct($week)
    {
        $this->week = $week;
        $this->dayOfWorks = new ArrayCollection();
    }

    public function addDayOfWork(DayOfWork $dayOfWork)
    {
        $this->dayOfWorks->add($dayOfWork);

        return $this;
    }

    public function getDayOfWorks()
    {
        return $this->dayOfWorks;
    }

    public function setDayOfWorks($dayOfWorks)
    {
        foreach ($dayOfWorks as $dayOfWork) {
            $this->addDayOfWork($dayOfWork);
        }

        return $this;
    }

    public function getWeek()
    {
        return $this->week;
    }

    public function setWeek($week)
    {
        $this->week = $week;

        return $this;
    }
}
