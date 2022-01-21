<?php

namespace ActivityTimetable\Entity;

use ActivityTimetable\Domain\Project as ProjetModel;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ActivityTimetable\Entity\Repository\ProjectRepository")
 * 
 * @author Hessé <sylvain.carite@gmail.com>
 */
class Project extends ProjetModel
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Type("integer")
     * @JMS\Groups({"weeksOfWork", "projectCget", "projectGet"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @JMS\Type("string")
     * @JMS\Groups({"weeksOfWork", "projectCget", "projectGet"})
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @JMS\Type("string")
     * @JMS\Groups({"weeksOfWork", "projectCget", "projectGet"})
     */
    protected $description;

    /**
     * @var Task[]
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="project")
     *
     * @JMS\Exclude()
     */
    protected $tasks;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     *
     * @JMS\Exclude()
     */
    protected $parent;

    public function __construct()
    {
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param \Iterable $tasks
     *
     * @return self
     */
    protected function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("parent_id")
     * @JMS\Type("integer")
     * @JMS\Groups({"weeksOfWork", "projectCget", "projectGet"})
     */
    public function getParentId()
    {
        if ($this->parent!==null)
            return $this->parent->getId();
        return null;
    }
}
