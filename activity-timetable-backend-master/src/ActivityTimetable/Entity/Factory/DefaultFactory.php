<?php

namespace ActivityTimetable\Entity\Factory;

use JMS\DiExtraBundle\Annotation as DI;
use ActivityTimetable\Entity\Project;
use ActivityTimetable\Entity\Task;

/**
 * @DI\Service("activity_timetable.orm.factory.default")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class DefaultFactory implements EntityFactoryInterface
{
    public function getProject($name, $description = null)
    {
        return new Project($name, $description);
    }

    public function getTask(Project $project, \DateTime $day, $duration, $description = null)
    {
        return new Task($project, $day, $duration, $description);
    }
}
