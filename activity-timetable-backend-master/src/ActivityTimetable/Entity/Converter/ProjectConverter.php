<?php

namespace ActivityTimetable\Entity\Converter;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("activity_timetable.orm.converter.project")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectConverter implements EntityConverterInterface
{
    public function transform($model)
    {
        throw new \Exception("not yet implemented");
    }

    public function reverseTransform($entity)
    {
        throw new \Exception("not yet implemented");
    }
}
