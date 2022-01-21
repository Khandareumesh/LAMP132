<?php

namespace ActivityTimetable\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;
use ActivityTimetable\Domain\Project;
use ActivityTimetable\Domain\Task;
use ActivityTimetable\Entity\Converter\TaskConverter;
use ActivityTimetable\Entity\Factory\EntityFactoryInterface;
use ActivityTimetable\Entity\Repository\ProjectRepository;
use ActivityTimetable\Entity\Repository\TaskRepository;
use ActivityTimetable\Entity\Task as TaskEntity;
use ActivityTimetable\Exception\EntityNotFoundException;

/**
 * @DI\Service("activity_timetable.manager.task")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskManager
{
    protected $entityFactory;
    protected $taskConverter;
    protected $projectRepository;
    protected $om;
    protected $repository;

    /**
     * @DI\InjectParams({
     *     "repository"        = @DI\Inject("activity_timetable.repository.task"),
     *     "taskConverter"     = @DI\Inject("activity_timetable.orm.converter.task"),
     *     "projectRepository" = @DI\Inject("activity_timetable.repository.project"),
     *     "entityFactory"     = @DI\Inject("activity_timetable.orm.factory.default"),
     *     "om"                = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(
        TaskRepository $repository,
        TaskConverter $taskConverter,
        ProjectRepository $projectRepository,
        EntityFactoryInterface $entityFactory,
        ObjectManager $om)
    {
        $this->repository        = $repository;
        $this->taskConverter     = $taskConverter;
        $this->projectRepository = $projectRepository;
        $this->entityFactory     = $entityFactory;
        $this->om                = $om;
    }

    public function create($projectId, \DateTime $day, $duration, $description = null)
    {
        $project = $this->getProject($projectId);

        return $this->entityFactory->getTask($project, $day, $duration, $description);
    }

    public function save($tasks)
    {
        if (is_array($tasks) || $tasks instanceof \Traversable) {
            foreach ($tasks as $task) {
                $this->saveOne($task);
            }
        } else {
            $this->saveOne($tasks);
        }

        return $this;
    }

    public function getTask($taskId)
    {
        $task = $this->repository->find($taskId);
        if ($task === null) {
            throw new EntityNotFoundException("No entity Task '$taskId'");
        }

        return $task;
    }

    public function getProject($projectId)
    {
        $project = $this->projectRepository->find($projectId);
        if ($project === null) {
            throw new EntityNotFoundException("No entity Project '$projectId'");
        }

        return $project;
    }

    public function delete(Task $task)
    {
        $this->om->remove($task);
        $this->om->flush();

        return $this;
    }

    protected function saveOne(Task $task)
    {
        if (!($task instanceof TaskEntity)) {
            $task = $this->taskConverter->transform($task);
        }
        $this->om->persist($task);
        $this->om->flush();

        return $this;
    }
}
