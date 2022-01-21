<?php

namespace ActivityTimetable\Domain;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class Task
{
    /**
     * @var \DateTime
     */
    protected $day;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Project
     */
    protected $project;

    public function __construct(Project $project, \DateTime $day, $duration, $description = null)
    {
        $this->setProject($project);
        $this->setDay($day);
        $this->setDuration($duration);
        $this->setDescription($description);
    }

    public function isSimultaneous(\DateTime $datetime)
    {
        return $this->day->format('Y-m-d') == $datetime->format('Y-m-d');
    }

    /**
     * Set day
     *
     * @param  \DateTime $day
     * @return Task
     */
    public function setDay(\DateTime $day)
    {
        $this->day = $day->setTime(0, 0, 0);

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set duration
     *
     * @param  integer $duration
     * @return Task
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set project
     *
     * @param  Project $project
     * @return Task
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
