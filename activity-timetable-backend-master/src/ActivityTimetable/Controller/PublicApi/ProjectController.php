<?php

namespace ActivityTimetable\Controller\PublicApi;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ActivityTimetable\Entity\Project;
use ActivityTimetable\Form\Model\ProjectGet;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class ProjectController extends Controller implements ClassResourceInterface
{
    /**
     * @DI\Inject("activity_timetable.manager.project")
     *
     * @var ProjectManager
     */
    private $projectManager;

    /**
     * @Rest\View(
     *  templateVar="",
     *  statusCode=null,
     *  serializerGroups={"projectGet"},
     *  populateDefaultVars=true,
     *  serializerEnableMaxDepthChecks=false
     * )
     * 
     * @ApiDoc(
     *     section="Project",
     *     description="Get a project",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getAction(Project $project)
    {
        return $project;
    }

    /**
     * @Rest\View(
     *  templateVar="",
     *  statusCode=null,
     *  serializerGroups={"projectCget"},
     *  populateDefaultVars=true,
     *  serializerEnableMaxDepthChecks=false
     * )
     * 
     * @ApiDoc(
     *     section="Project",
     *     description="Get a list of projects",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function cgetAction()
    {
        $project = new ProjectGet();
        $this->get('activity_timetable.handler.project_get')->process($this->get('request'), $project);

        return $this->get('activity_timetable.repository.project')->findByApiCriteria($project->toArray());
    }

    /**
     * @Rest\RequestParam(
     *     name="name",
     *     default=null,
     *     description="name of the project",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="description",
     *     description="description of the project",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="parent",
     *     description="parent project of the project",
     *     nullable=true,
     * )
     *
     * @ApiDoc(
     *     section="Project",
     *     description="Create a project"
     * )
     */
    public function postAction()
    {
        $project = new Project();
        $this->get('activity_timetable.handler.project_create')->process($this->get('request'), $project);

        return $project;
    }

    /**
     * @Rest\RequestParam(
     *     name="name",
     *     description="name of the project",
     *     nullable=true,
     * )
     * @Rest\RequestParam(
     *     name="description",
     *     description="description of the project",
     *     nullable=true,
     * )
     *
     * @ApiDoc(
     *     section="Project",
     *     description="Update a project"
     * )
     */
    public function patchAction(Project $project)
    {
        $this->get('activity_timetable.handler.project_update')->process($this->get('request'), $project);

        return $project;
    }

    /**
     * @Rest\RequestParam(
     *     name="name",
     *     default=null,
     *     description="name of the project",
     *     nullable=false,
     * )
     * @Rest\RequestParam(
     *     name="description",
     *     description="description of the project",
     *     nullable=false,
     * )
     *
     * @ApiDoc(
     *     section="Project",
     *     description="Update a project"
     * )
     */
    public function putAction(Project $project)
    {
        $this->get('activity_timetable.handler.project_update')->process($this->get('request'), $project);

        return $project;
    }

    /**
     * @ApiDoc(
     *     section="Project",
     *     description="Delete a project"
     * )
     */
    public function deleteAction(Project $project)
    {
        $this->projectManager->delete($project);

        return $project;
    }
}
