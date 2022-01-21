<?php

namespace ActivityTimetable\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;
use ActivityTimetable\Domain\Project;
use ActivityTimetable\Entity\Converter\ProjectConverter;
use ActivityTimetable\Entity\Factory\EntityFactoryInterface;
use ActivityTimetable\Entity\Project as ProjectEntity;

/**
 * @DI\Service("activity_timetable.manager.project")
 *
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectManager
{
    protected $projectConverter;
    protected $entityFactory;
    protected $om;

    /**
     * @DI\InjectParams({
     *     "projectConverter" = @DI\Inject("activity_timetable.orm.converter.project"),
     *     "entityFactory"    = @DI\Inject("activity_timetable.orm.factory.default"),
     *     "om"               = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(ProjectConverter $projectConverter, EntityFactoryInterface $entityFactory, ObjectManager $om)
    {
        $this->projectConverter = $projectConverter;
        $this->entityFactory    = $entityFactory;
        $this->om               = $om;
    }

    public function create($name, $description = null)
    {
        return $this->entityFactory->getProject($name, $description);
    }

    public function save($projects)
    {
        if ( is_array($projects) || $projects instanceof \Traversable ) {
            foreach ($projects as $project) {
                $this->saveOne($project);
            }
        } else {
            $this->saveOne($projects);
        }

        return $this;
    }

    protected function saveOne(Project $project)
    {
        if (!($project instanceof ProjectEntity)) {
            $project = $this->projectConverter->transform($project);
        }
        $this->om->persist($project);
        $this->om->flush();

        return $this;
    }

    public function delete(Project $project)
    {
        throw new \Exception('not yet iplemented');
    }
}
