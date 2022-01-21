<?php

namespace ActivityTimetable\Exception;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class SecurityLoopException extends \RuntimeException
{
    public function __construct($count)
    {
        parent::__construct("Security loop reached '$count'");
    }
}
