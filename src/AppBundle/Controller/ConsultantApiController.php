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
    * @QueryParam(name="rangeAvailability-a", requirements="\d+", default="0")
    * @QueryParam(name="rangeAvailability-b", requirements="\d+", default="4")
    * @QueryParam(name="valueOnMissionSince", requirements="\d+", default="0")
    * @QueryParam(name="language-level", default="")
    * @QueryParam(name="exp-choice", default="")
    * @param ParamFetcher $paramFetcher 
    */
    public function getConsultantsAction(ParamFetcher $paramFetcher)
    {   
        $searchQuery =  http_build_query($paramFetcher->all());
        $this->getDoctrine()->getRepository('AppBundle:Searches')->insertSearch($this->getUser()->getId(), $searchQuery);
        $consultants = $this->getDoctrine()->getRepository('AppBundle:Consultant')->findByAvailability($paramFetcher->all()); // get data, in this case list of consultants.
        $favoris =  $this->getDoctrine()->getRepository('AppBundle:Favoris')->findUserFavorites($this->getUser()->getId());
        $searchold= $this->getDoctrine()->getRepository('AppBundle:Searches')->findOneBy(array("isavailable"=>true,
                                                                                               "userId"=>$this->getUser()->getId(),
                                                                                               "query"=>$searchQuery));
        
                                                                                           
        $data = array("consultants"=> $consultants,
                      "favorites"=> $favoris);
        
        
        if(!empty($searchold)){
            $data["searchId"] = $searchold->getId();
        }
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    public function getFavoritesConsultantsAction(){
        $consultants =  $this->getDoctrine()->getRepository('AppBundle:Favoris')->findUserFavoritesConsultants($this->getUser()->getId());
        $favoris =  $this->getDoctrine()->getRepository('AppBundle:Favoris')->findUserFavorites($this->getUser()->getId());
        $data = array("consultants"=> $consultants,
                      "favorites"=> $favoris);
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    public function getFavoritesAction(){
        $data =  $this->getDoctrine()->getRepository('AppBundle:Favoris')->findUserFavorites($this->getUser()->getId());
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    /**
    * @var integer $consultantID
    */
    public function putFavoriteAction($consultantId){
        $data= $this->getDoctrine()->getRepository('AppBundle:Favoris')
                ->addUserFavorite($this->getUser()->getId(), $consultantId);
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    /**
    * @QueryParam(name="consultant_id", requirements="\d+")
    * @param ParamFetcher $paramFetcher 
    */
    public function removeFavoriteAction(ParamFetcher $paramFetcher){
        $data= $this->getDoctrine()->getRepository('AppBundle:Favoris')
                ->removeUserFavorite($this->getUser()->getId(), $paramFetcher->get("consultant_id"));
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    public function getSearchesAction(){
        $data= $this->getDoctrine()->getRepository('AppBundle:Searches')
                ->findUserSearches($this->getUser()->getId());
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    
    public function putSearchAction(){
        $data= $this->getDoctrine()->getRepository('AppBundle:Searches')
                ->saveLastUserSearch($this->getUser()->getId());
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:api:consultants.html.twig")
            ->setTemplateVar('consultants')
        ;
        $handleView= $this->handleView($view);
        return $handleView;
    }
    
    /**
    * @var integer $searchId
    */
    public function removeSearchAction($searchId){
        $data= $this->getDoctrine()->getRepository('AppBundle:Searches')
                ->removeUserSearch($searchId);
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