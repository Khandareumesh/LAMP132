<?php

namespace ActivityTimetable\Entity\Converter;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("activity_timetable.orm.converter.task")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class TaskConverter implements EntityConverterInterface
{
    protected $projectConverter;

    /**
     * @DI\InjectParams({
     *     "projectConverter" = @DI\Inject("activity_timetable.orm.converter.project")
     * })
     */
    public function __construct(EntityConverterInterface $projectConverter)
    {
        $this->projectConverter = $projectConverter;
    }

    public function transform($model)
    {
        throw new \Exception("not yet implemented");
    }

    public function reverseTransform($entity)
    {
        throw new \Exception("not yet implemented");
    }
}
