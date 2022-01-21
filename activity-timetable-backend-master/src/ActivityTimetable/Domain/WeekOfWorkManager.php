<?php

namespace ActivityTimetable\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("activity_timetable.manager.week_of_work")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class WeekOfWorkManager
{
    protected $dayOfWorkManager;

    /**
     * @DI\InjectParams({
     *     "dayOfWorkManager" = @DI\Inject("activity_timetable.manager.day_of_work")
     * })
     */
    public function __construct(DayOfWorkManager $dayOfWorkManager)
    {
        $this->dayOfWorkManager = $dayOfWorkManager;
    }

    public function create($week)
    {
        return new WeekOfWork($week);
    }

    public function getWeeks($year = null, $month = null)
    {
        $weeks = new ArrayCollection();
        $dayOfWorkCollection = $this->dayOfWorkManager->getMonth($year, $month);

        foreach ($dayOfWorkCollection as $dayOfWork) {
            $week = $dayOfWork->getDay()->format('W');
            $yearWeek = $dayOfWork->getDay()->format('YW');
            if (!$weeks->containsKey($yearWeek)) {
                $weeks->set($yearWeek, $this->create($week));
            }
            $weeks[$yearWeek]->addDayOfWork($dayOfWork);
        }

        $this->reverseWeeks($weeks);

        return $weeks->getValues();
    }

    public function reverseWeeks(&$weeks)
    {
        $keys = $weeks->getKeys();
        for ($i = count($keys)-1; $i >= 0; $i--) {
            $key = $keys[$i];
            $week = $weeks[$key];
            $weeks->remove($key);
            $weeks->set($key, $week);
        }
    }
}
