<?php

namespace ActivityTimetable\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class DayOfWork
{
    /**
     * Tasks collection
     * @var ArrayCollection
     *
     * @JMS\Type("ArrayCollection<ActivityTimetable\Entity\Task>")
     * @JMS\Groups({"weeksOfWork"})
     */
    protected $tasks;

    /**
     * Day
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\Groups({"weeksOfWork"})
     */
    protected $day;

    /**
     * Specification that must be verified for this day of work
     * @var DayOfWorkSpecificationInterface
     */
    protected $specification;

    public function __construct(DayOfWorkSpecificationInterface $specification, \DateTime $day)
    {
        $this->tasks = new ArrayCollection();
        $this->specification = $specification;
        $this->setDay($day);
    }

    /**
     * Adds or replaces task in current tasks collection.
     *
     * @param  Task $task
     * @return void
     */
    public function mergeTask(Task $task)
    {
        if ( !$task->isSimultaneous($this->day) )
            throw new \InvalidArgumentException('Task day not corresponding to DayOfWork day.');

        $isFound = false;
        foreach ($this->tasks as $task1) {
            if ( $task1->getId() == $task->getId() ) {
                $isFound = true;
                break;
            }
        }
        if ( $isFound )
            $this->tasks->removeElement($task1);

        $this->tasks->add($task);
    }

    /**
     * Throws an exception if the current tasks collection does not respect specification.
     *
     * @return void
     */
    public function assertFulfilledSpecification()
    {
        if (!$this->specification->isSatisfiedBy($this)) {
            $currentDuration = $this->getTotalDuration();
            throw new DayOfWorkOverflowException($this->specification->getDuration(), $currentDuration);
        }
    }

    /**
     * Returns the total duration of the current tasks collection.
     *
     * @return int
     */
    public function getTotalDuration()
    {
        $duration = 0;
        foreach ($this->tasks as $task) {
            $duration += $task->getDuration();
        }

        return $duration;
    }

    /**
     * Returns a collection of total duration indexed by project name.
     *
     * @return ArrayCollection
     */
    public function getDurationByProject()
    {
        $durations = new ArrayCollection();
        foreach ($this->tasks as $task) {
            $key = $task->getProject()->getName();
            if (!$durations->containsKey($key)) {
                $durations->set($key, 0);
            }
            $durations[$key] += $task->getDuration();
        }

        return $durations;
    }

    /**
     * Returns the current projects collection.
     *
     * @return ArrayCollection
     */
    public function getProjects()
    {
        $projects = new ArrayCollection();
        foreach ($this->tasks as $task) {
            $projects->add($task->getProject());
        }

        return $projects;
    }

    /**
     * Returns the current tasks collection.
     *
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Sets current tasks collection using self::mergeTask on every task.
     *
     * @param  array|\Traversable        $tasks
     * @return self
     * @throws \InvalidArgumentException If argument $tasks is incorrect
     */
    public function setTasks($tasks)
    {
        if ( !is_array($tasks) && !($tasks instanceof \Traversable) )
            throw new \InvalidArgumentException("argument \$tasks must be an array or a \Traversable object");

        $this->tasks->clear();
        foreach($tasks as $task)
            $this->mergeTask($task);

        return $this;
    }

    /**
     * Returns the current day.
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Sets current day with a date and set the time to 0.
     *
     * @param  \DateTime $day
     * @return self
     */
    public function setDay(\DateTime $day)
    {
        $this->day = $day->setTime(0, 0, 0);

        return $this;
    }
}
