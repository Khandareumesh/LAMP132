<?php

namespace ActivityTimetable\Form\Handler\Task;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormFactoryInterface;
use ActivityTimetable\Domain\DayOfWorkManager;
use ActivityTimetable\Entity\Task;
use ActivityTimetable\Manager\TaskManager;

/**
 * @DI\Service("activity_timetable.handler.task", abstract=true)
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
abstract class AbstractTaskHandler
{
    protected $formFactory;
    protected $taskManager;
    protected $dayOfWorkManager;

    /**
     * @DI\InjectParams({
     *     "formFactory" = @DI\Inject("form.factory"),
     *     "taskManager" = @DI\Inject("activity_timetable.manager.task"),
     *     "dayOfWorkManager" = @DI\Inject("activity_timetable.manager.day_of_work")
     * })
     */
    public function __construct(FormFactoryInterface $formFactory, TaskManager $taskManager, DayOfWorkManager $dayOfWorkManager)
    {
        $this->formFactory      = $formFactory;
        $this->taskManager      = $taskManager;
        $this->dayOfWorkManager = $dayOfWorkManager;
    }
}
