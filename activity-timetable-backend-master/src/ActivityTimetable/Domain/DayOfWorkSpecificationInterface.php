<?php

namespace ActivityTimetable\Domain;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
interface DayOfWorkSpecificationInterface extends SpecificationInterface
{
    public function getDuration();
}
