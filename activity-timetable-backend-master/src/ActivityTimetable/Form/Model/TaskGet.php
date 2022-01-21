<?php

namespace ActivityTimetable\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskGet
{
    /**
     * @var string
     *
     * @Assert\Regex(message="tasks must be integer or integers list", pattern="/^[0-9]+(,[0-9]+)*$/")
     */
    protected $tasks;

    /**
     * @var string
     *
     * @Assert\Regex(message="projects must be integer or integers list", pattern="/^[0-9]+(,[0-9]+)*$/")
     */
    protected $projects;

    /**
     * @var \DateTime
     *
     * Assert\Date("dayStart must be a date")
     */
    protected $dayStart;

    /**
     * @var \DateTime
     *
     * Assert\Date("dayEnd must be a date")
     */
    protected $dayEnd;

    public function toArray()
    {
        return [
            'tasks'    => $this->getTaskList(),
            'projects' => $this->getProjectList(),
            'dayStart' => $this->dayStart,
            'dayEnd'   => $this->dayEnd,
        ];
    }

    public function getTaskList()
    {
        if ($this->tasks===null)
            return [];

        return explode(',', $this->tasks);
    }

    public function getProjectList()
    {
        if ($this->projects===null)
            return [];

        return explode(',', $this->projects);
    }

    /**
     * Gets the value of tasks.
     *
     * @return string
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Sets the value of tasks.
     *
     * @param string $tasks the tasks
     *
     * @return self
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Gets the value of projects.
     *
     * @return string
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Sets the value of projects.
     *
     * @param string $projects the projects
     *
     * @return self
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * Gets the Assert\Date("dayStart must be a date").
     *
     * @return \DateTime
     */
    public function getDayStart()
    {
        return $this->dayStart;
    }

    /**
     * Sets the Assert\Date("dayStart must be a date").
     *
     * @param \DateTime $dayStart the day start
     *
     * @return self
     */
    public function setDayStart(\DateTime $dayStart = null)
    {
        if ( $dayStart !== null )
            $this->dayStart = $dayStart->setTime(0, 0, 0);

        return $this;
    }

    /**
     * Gets the Assert\Date("dayEnd must be a date").
     *
     * @return \DateTime
     */
    public function getDayEnd()
    {
        return $this->dayEnd;
    }

    /**
     * Sets the Assert\Date("dayEnd must be a date").
     *
     * @param \DateTime $dayEnd the day end
     *
     * @return self
     */
    public function setDayEnd(\DateTime $dayEnd = null)
    {
        if ( $dayEnd !== null )
            $this->dayEnd = $dayEnd->setTime(0, 0, 0);

        return $this;
    }
}
