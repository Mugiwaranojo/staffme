<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class ConsultantApiController extends FOSRestController
{
    /**
    * @QueryParam(name="inputKeywords", default="")
    * @QueryParam(name="inputFunctions", default="")
    * @QueryParam(name="rangeAvailability-a", requirements="\d+", default="0")
    * @QueryParam(name="rangeAvailability-b", requirements="\d+", default="4")
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
        $handleView->headers->addCacheControlDirective('no-cache', true);
        $handleView->headers->addCacheControlDirective('max-age', 0);
        $handleView->headers->addCacheControlDirective('must-revalidate', true);
        $handleView->headers->addCacheControlDirective('no-store', true);
        return $handleView;
    }
}
?>