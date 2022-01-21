<?php

namespace ActivityTimetable\Domain;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class DayOfWorkOverflowException extends \RuntimeException
{
    public function __construct($duration, $currentDuration)
    {
        parent::__construct("Day of work duration '$currentDuration' exceeds maximum duration '$duration'");
    }
}
