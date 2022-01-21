<?php

namespace ActivityTimetable\Controller\PublicApi;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 *
 * @Rest\NamePrefix("api_calculation_")
 */
class CalculationController extends Controller implements ClassResourceInterface
{
    /**
     * @DI\Inject("activity_timetable.manager.week_of_work")
     *
     * @var TaskManager
     */
    private $weekOfWorkManager;

    /**
     * @Rest\QueryParam(
     *     name="year",
     *     key="year",
     *     default=null,
     *     description="",
     *     nullable=true,
     * )
     * @Rest\QueryParam(
     *     name="month",
     *     key="month",
     *     default=null,
     *     description="",
     *     nullable=true,
     * )
     * @Rest\View(
     *  templateVar="",
     *  statusCode=null,
     *  serializerGroups={"weeksOfWork"},
     *  populateDefaultVars=true,
     *  serializerEnableMaxDepthChecks=false
     * )
     *
     * @ApiDoc(
     *     section="Calculation",
     *     description="Get a list of tasks",
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
    public function cgetWeeksAction()
    {
        $params = $this->get('request')->query;

        return $this->weekOfWorkManager->getWeeks($params->get('year'), $params->get('month'));

            // 'durations'   => $this->get('activity_timetable.manager.day_of_work')->getDurationByProject($year, $month),
        // $task = new TaskGet();
        // $this->get('activity_timetable.handler.task_get')->process($this->get('request'), $task);

        // return $this->get('doctrine')->getManager()->getRepository('ActivityTimetableBundle:Task')->findByApiCriteria($task->toArray());
    }

    /**
     * @Rest\QueryParam(
     *     name="year",
     *     key="year",
     *     default=null,
     *     description="",
     *     nullable=true,
     * )
     * @Rest\QueryParam(
     *     name="month",
     *     key="month",
     *     default=null,
     *     description="",
     *     nullable=true,
     * )
     * @Rest\View(
     *  templateVar="",
     *  statusCode=null,
     *  serializerGroups={"projectsDuration"},
     *  populateDefaultVars=true,
     *  serializerEnableMaxDepthChecks=false
     * )
     *
     * @ApiDoc(
     *     section="Calculation",
     *     description="Get a list of tasks",
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
    public function cgetProjectsAction()
    {
        $params = $this->get('request')->query;
    }
}
