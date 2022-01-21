<?php

namespace ActivityTimetable\Form\Handler\Project;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;
use ActivityTimetable\Form\Model\ProjectGet;

/**
 * @DI\Service("activity_timetable.handler.project_get", parent="activity_timetable.handler.project")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectGetHandler extends AbstractProjectHandler
{
    public function process(Request $request, ProjectGet $project)
    {
        $form = $this->formFactory->create('project_get', $project);
        $form->submit($request->query->all());

        if (!$form->isValid()) {
            throw new ValidatorException($form->getErrorsAsString());
        }
    }
}
