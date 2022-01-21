<?php

namespace ActivityTimetable\Domain;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class DayOfWorkSpecification implements DayOfWorkSpecificationInterface
{
    protected $duration;

    public function __construct($duration)
    {
        $this->duration = $duration;
    }

    public function isSatisfiedBy(DayOfWork $dayOfWork)
    {
        return $dayOfWork->getTotalDuration() <= $this->duration;
    }

    public function getDuration()
    {
        return $this->duration;
    }
}
