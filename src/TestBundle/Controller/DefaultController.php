<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function indexAction()
    {
    	$response = $this->forward('TestBundle:Produits:grid');
    	
    	// ... further modify the response or return it directly
    	
    	return $response;
    }
}
