<?php

namespace ActivityTimetable;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use ActivityTimetable\Util\DebugLogger;

class ActivityTimetableBundle extends Bundle
{
    public function boot()
    {
        parent::boot();
        DebugLogger::init($this->container->get('logger'));
    }
}
