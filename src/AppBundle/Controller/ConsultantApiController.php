<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RouteResource;


class ConsultantApiController extends FOSRestController
{
    /**
    * @QueryParam(name="inputKeywords", default="")
    * @QueryParam(name="inputFunctions", default="")
    * @QueryParam(name="rangeAvailability-a", requirements="\d+", default="0")
    * @QueryParam(name="rangeAvailability-b", requirements="\d+", default="4")
    * @QueryParam(name="valueOnMissionSince", requirements="\d+", default="0")
    * @QueryParam(name="language-choice", default="")
    * @QueryParam(name="language-choiceChecked", default="")
    * @QueryParam(name="exp-choice", default="")
    * @param ParamFetcher $paramFetcher 
    */
    public function getConsultantsAction(ParamFetcher $paramFetcher)
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Consultant')->findByAvailability($paramFetcher->all()); // get data, in this case list of consultants.
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    public function getTagsAction(){
        $data= $this->getDoctrine()->getRepository('AppBundle:Consultant')->findAllTags();
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
        
    }
}
?>