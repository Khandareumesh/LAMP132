<?php

namespace ActivityTimetable\Form\Handler\Project;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;
use ActivityTimetable\Entity\Project;

/**
 * @DI\Service("activity_timetable.handler.project_create", parent="activity_timetable.handler.project")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectCreateHandler extends AbstractProjectHandler
{
    public function process(Request $request, Project $project)
    {
        $form = $this->formFactory->create('project', $project);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            throw new ValidatorException($form->getErrorsAsString());
        }

        $this->onSuccess($project);
    }

    protected function onSuccess(Project $project)
    {
        throw new \Exception('not yet implemented');
    }
}
