<?php

namespace ActivityTimetable\ParamConverter;

use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use ActivityTimetable\Form\Task;
use ActivityTimetable\Util\Inflector;

/**
 * @DI\Service("activity_timetable.param_converter.task")
 * @DI\Tag("request.param_converter", attributes = { "priority" = "20", "converter" = "task_converter" })
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = $configuration->getName();

        $task = new Task();
        $task->taskId    = Inflector::getRequestAttribute($request, 'id');
        $task->projectId = Inflector::getRequestRequest($request, 'projectId');
        $task->duration  = Inflector::getRequestRequest($request, 'duration');
        $task->day       = Inflector::getRequestRequest($request, 'day');

        $request->attributes->set($param, $task);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return "ActivityTimetable\Form\Task" === $configuration->getClass();
    }
}
