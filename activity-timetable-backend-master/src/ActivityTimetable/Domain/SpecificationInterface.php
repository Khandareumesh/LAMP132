<?php

namespace ActivityTimetable\Domain;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
interface SpecificationInterface
{
    public function isSatisfiedBy(DayOfWork $dayOfWork);
}
