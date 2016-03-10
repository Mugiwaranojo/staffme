<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig');
    }
	
	/**
     * @Route("/search", name="searchpage")
     */
    public function searchAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:default:search.html.twig');
    }
}
