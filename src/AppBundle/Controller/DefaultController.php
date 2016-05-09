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
        return $this->redirectToRoute('searchpage');
    }
	
    /**
     * @Route("/search", name="searchpage")
     */
    public function searchAction(Request $request)
    {
        return $this->render('AppBundle:default:search.html.twig');
    }
    
    /**
     * @Route("/favorites", name="favoritespage")
     */
    public function favoritesAction(Request $request)
    {
        return $this->render('AppBundle:default:favorites.html.twig');
    }
    
    /**
     * @Route("/myresearches", name="myresearchespage")
     */
    public function myresearchesAction(Request $request)
    {
        return $this->render('AppBundle:default:myresearches.html.twig');
    }
}
