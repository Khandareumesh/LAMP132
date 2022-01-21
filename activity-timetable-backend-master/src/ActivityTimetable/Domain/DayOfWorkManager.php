<?php

namespace ActivityTimetable\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\DiExtraBundle\Annotation as DI;
use ActivityTimetable\Entity\Repository\TaskRepository;
use ActivityTimetable\Exception\SecurityLoopException;
use ActivityTimetable\Manager\ProjectManager;
use ActivityTimetable\Manager\TaskManager;

/**
 * @DI\Service("activity_timetable.manager.day_of_work")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class DayOfWorkManager
{
    protected $projectManager;
    protected $taskManager;
    protected $taskRepository;

    /**
     * @DI\InjectParams({
     *     "projectManager" = @DI\Inject("activity_timetable.manager.project"),
     *     "taskManager"    = @DI\Inject("activity_timetable.manager.task"),
     *     "taskRepository" = @DI\Inject("activity_timetable.repository.task")
     * })
     */
    public function __construct(ProjectManager $projectManager, TaskManager $taskManager, TaskRepository $taskRepository)
    {
        $this->projectManager = $projectManager;
        $this->taskManager    = $taskManager;
        $this->taskRepository = $taskRepository;
    }

    public function create(\DateTime $day)
    {
        return new DayOfWork(new DayOfWorkSpecification(8), $day);
    }

    public function save(DayOfWork $dayOfWork)
    {
        $this->projectManager->save($dayOfWork->getProjects());
        $this->taskManager->save($dayOfWork->getTasks());
    }

    public function mergeTask(Task $task)
    {
        $dayOfWork = $this->getByDay($task->getDay());
        $dayOfWork->mergeTask($task);
        $dayOfWork->assertFulfilledSpecification();
        $this->save($dayOfWork);

        return $this;
    }

    public function getByDay(\DateTime $day)
    {
        $dayOfWork = $this->create($day);
        $tasks = $this->taskRepository->findByDay($day);
        $dayOfWork->setTasks($tasks);

        return $dayOfWork;
    }

    public function getMonth($year, $month)
    {
        $now = new \DateTime('now');
        if ($year === null) {
            $year = $now->format('Y');
        }
        if ($month === null) {
            $month = $now->format('m');
        }

        $securityLoop = 0;
        $dayOfWorkCollection = new ArrayCollection();

        $from = new \DateTime("$year-$month-01 00:00:00");
        $to = clone $from;
        $to->add(\DateInterval::createFromDateString('1 month'));
        $to->sub(\DateInterval::createFromDateString('1 day'));
        if ($to > $now) {
            $to = $now;
        }

        while ($from <= $to) {
            $weekDay = (int) $from->format('N');
            if ($weekDay >= 1 && $weekDay <= 5) {
                $dayString = $from->format('Ymd');
                $dayOfWork = $this->create(clone $from);
                $dayOfWork->setTasks($this->taskRepository->findByDay($from));
                $dayOfWorkCollection->set($dayString, $dayOfWork);
            }

            $from->add(\DateInterval::createFromDateString('1 day'));

            if ($securityLoop++ >= 100) {
                throw new SecurityLoopException(100);
            }
        }

        return $dayOfWorkCollection->getValues();
    }

    public function getDurationByProject($year, $month)
    {
        $durations = new ArrayCollection();
        foreach ($this->getMonth($year, $month) as $dayOfWork) {
            foreach ($dayOfWork->getDurationByProject() as $projectName => $duration) {
                if (!$durations->containsKey($projectName)) {
                    $durations->set($projectName, 0);
                }
                $durations[$projectName] += $duration;
            }
        }

        return $durations;
    }

    public function getLastWeeks($weekCount)
    {
        throw new \Exception("not yet implemented");
    }

    public function getAll()
    {
        $dayOfWorkCollection = new ArrayCollection();

        $tasks = $this->taskRepository->findAll();
        foreach ($tasks as $task) {
            $dayString = $task->getDay()->format('Ymd');
            $dayOfWork = $dayOfWorkCollection->get($dayString);
            if ($dayOfWork === null) {
                $dayOfWork = $this->create($task->getDay());
                $dayOfWorkCollection->set($dayString, $dayOfWork);
            }
            $dayOfWork->addTask($task);
        }

        return $dayOfWorkCollection;
    }
}
