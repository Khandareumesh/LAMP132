<?php

namespace ActivityTimetable\Domain;

use ActivityTimetable\Domain\Project;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class Project
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;
    
    /**
     * @var Project
     */
    protected $parent;

    public function __construct($name, $description = null)
    {
        $this->setName($name);
        $this->setDescription($description);
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param  string  $description
     * @return Project
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
     * @return Project
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Project $parent
     *
     * @return self
     */
    protected function setParent(Project $parent)
    {
        $this->parent = $parent;

        return $this;
    }
}
