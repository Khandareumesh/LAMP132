<?php

namespace ActivityTimetable\Form\Handler\Project;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * @DI\Service("activity_timetable.handler.project", abstract=true)
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
abstract class AbstractProjectHandler
{
    protected $formFactory;

    /**
     * @DI\InjectParams({
     *     "formFactory" = @DI\Inject("form.factory")
     * })
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory      = $formFactory;
    }
}
