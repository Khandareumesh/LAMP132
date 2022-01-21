<?php

namespace ActivityTimetable\Controller\PublicApi;

use ActivityTimetable\Entity\Task;
use ActivityTimetable\Form\Model\TaskGet;
use ActivityTimetable\Manager\TaskManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 *
 * @Rest\NamePrefix("api_task_")
 */
class TaskController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @DI\Inject("activity_timetable.manager.task")
     *
     * @var TaskManager
     */
    private $taskManager;

    /**
     * @ApiDoc(
     *     section="Task",
     *     description="Get a task",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getAction(Task $task)
    {
        return $task;
    }

    /**
     * @Rest\QueryParam(
     *     name="tasks",
     *     key="tasks",
     *     default=null,
     *     description="IDs of tasks where filtering on",
     *     nullable=true,
     * )
     * @Rest\QueryParam(
     *     name="projects",
     *     key="projects",
     *     default=null,
     *     description="project IDs where filtering on",
     *     nullable=true,
     * )
     * @Rest\QueryParam(
     *     name="dayStart",
     *     key="dayStart",
     *     description="filtering tasks where day is greater or equal",
     *     nullable=true,
     * )
     * @Rest\QueryParam(
     *     name="dayEnd",
     *     key="dayEnd",
     *     description="filtering tasks where day is lower or equal",
     *     nullable=true,
     * )
     *
     * @ApiDoc(
     *     section="Task",
     *     description="Get a list of tasks",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function cgetAction()
    {
        $task = new TaskGet();
        $this->get('activity_timetable.handler.task_get')->process($this->get('request'), $task);

        return $this->get('activity_timetable.repository.task')->findByApiCriteria($task->toArray());
    }

    /**
     * @Rest\RequestParam(
     *     name="duration",
     *     requirements="^[0-9]+$",
     *     default=null,
     *     description="duration of the task in hours",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="project",
     *     requirements="^[0-9]+$",
     *     description="ID of the associated project of the task",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="day",
     *     requirements="^[0-9]{4}-[0-9]{2}-[0-9]{2}$",
     *     description="",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="description",
     *     description="description of the task",
     *     nullable=true,
     * )
     *
     * @ApiDoc(
     *     section="Task",
     *     description="Create a task"
     * )
     */
    public function postAction()
    {
        $task = new Task();
        $this->get('activity_timetable.handler.task_create')->process($this->get('request'), $task);

        return $task;
    }

    /**
     * @Rest\RequestParam(
     *     name="duration",
     *     requirements="^[0-9]+$",
     *     default=null,
     *     description="duration of the task in hours",
     *     nullable=true,
     * )
     * @Rest\RequestParam(
     *     name="project",
     *     requirements="^[0-9]+$",
     *     description="ID of the associated project of the task",
     *     nullable=true,
     * )
     * @Rest\RequestParam(
     *     name="day",
     *     requirements="^[0-9]{4}-[0-9]{2}-[0-9]{2}$",
     *     description="",
     *     nullable=true,
     * )
     * @Rest\RequestParam(
     *     name="description",
     *     description="description of the task",
     *     nullable=true,
     * )
     *
     * @ApiDoc(
     *     section="Task",
     *     description="Update a task"
     * )
     */
    public function patchAction(Task $task)
    {
        $this->get('activity_timetable.handler.task_update')->process($this->get('request'), $task);

        return $task;
    }

    /**
     * @Rest\RequestParam(
     *     name="duration",
     *     requirements="^[0-9]+$",
     *     default=null,
     *     description="duration of the task in hours",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="project",
     *     requirements="^[0-9]+$",
     *     description="ID of the associated project of the task",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="day",
     *     requirements="^[0-9]{4}-[0-9]{2}-[0-9]{2}$",
     *     description="",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="description",
     *     description="description of the task",
     *     nullable=false,
     * )
     *
     * @ApiDoc(
     *     section="Task",
     *     description="Update a task"
     * )
     */
    public function putAction(Task $task)
    {
        $this->get('activity_timetable.handler.task_update')->process($this->get('request'), $task);

        return $task;
    }

    /**
     * @ApiDoc(
     *     section="Task",
     *     description="Delete a task"
     * )
     */
    public function deleteAction(Task $task)
    {
        $this->taskManager->delete($task);

        return $task;
    }
}
