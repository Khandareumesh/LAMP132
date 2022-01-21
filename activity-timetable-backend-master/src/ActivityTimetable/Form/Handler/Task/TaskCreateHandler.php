<?php

namespace ActivityTimetable\Form\Handler\Task;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;
use ActivityTimetable\Entity\Task;

/**
 * @DI\Service("activity_timetable.handler.task_create", parent="activity_timetable.handler.task")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskCreateHandler extends AbstractTaskHandler
{
    public function process(Request $request, Task $task)
    {
        $form = $this->formFactory->create('task', $task);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            throw new ValidatorException($form->getErrorsAsString());
        }

        $this->onSuccess($task);
    }

    protected function onSuccess(Task $task)
    {
        $this->dayOfWorkManager->mergeTask($task);
    }
}
