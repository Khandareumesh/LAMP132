<?php

namespace ActivityTimetable\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use ActivityTimetable\Domain\Task as TaskModel;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ActivityTimetable\Entity\Repository\TaskRepository")
 * 
 * @author Hessé <sylvain.carite@gmail.com>
 */
class Task extends TaskModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Type("integer")
     * @JMS\Groups({"weeksOfWork"})
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="date")
     *
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\Groups({"weeksOfWork"})
     *
     * @Assert\NotBlank(message="day cannot be empty")
     * @Assert\Date(message="day must be date string")
     */
    protected $day;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer")
     *
     * @JMS\Type("integer")
     * @JMS\Groups({"weeksOfWork"})
     *
     * @Assert\NotBlank(message="duration cannot be empty")
     * @Assert\Regex("/^[0-9]*$/", message="duration must be integer")
     */
    protected $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @JMS\Type("string")
     * @JMS\Groups({"weeksOfWork"})
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     *
     * @JMS\Type("ActivityTimetable\Entity\Project")
     * @JMS\Groups({"weeksOfWork"})
     *
     * @Assert\NotBlank(message="project cannot be empty")
     */
    protected $project;

    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getProjectId()
    {
        return $this->getProject()->getId();
    }
}
