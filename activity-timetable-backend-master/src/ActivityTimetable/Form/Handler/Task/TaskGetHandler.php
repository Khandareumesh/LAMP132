<?php

namespace ActivityTimetable\Form\Handler\Task;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;
use ActivityTimetable\Form\Model\TaskGet;

/**
 * @DI\Service("activity_timetable.handler.task_get", parent="activity_timetable.handler.task")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskGetHandler extends AbstractTaskHandler
{
    public function process(Request $request, TaskGet $task)
    {
        $form = $this->formFactory->create('task_get', $task);
        $form->submit($request->query->all());

        if (!$form->isValid()) {
            throw new ValidatorException($form->getErrorsAsString());
        }
    }
}
