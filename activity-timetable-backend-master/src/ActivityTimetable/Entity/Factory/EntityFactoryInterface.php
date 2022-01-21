<?php

namespace ActivityTimetable\Entity\Factory;

use ActivityTimetable\Entity\Project;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
interface EntityFactoryInterface
{
    public function getProject($name, $description = null);

    public function getTask(Project $project, \DateTime $day, $duration, $description = null);
}
