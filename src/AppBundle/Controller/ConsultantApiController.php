<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class ConsultantApiController extends FOSRestController
{
	
    public function getConsultantsAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Consultant')->findAll(); // get data, in this case list of consultants.
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;

        return $this->handleView($view);
    }
}
?>