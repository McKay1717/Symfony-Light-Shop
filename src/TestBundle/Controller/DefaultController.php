<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TestBundle\Entity\Paniers;
use TestBundle\Entity\Produits;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="index")
	 * 
	 * @method ("GET")
	 */
	public function indexAction() {
		$paniers = new Paniers ();
		$em = $this->getDoctrine()->getManager();
		
		$produits = $em->getRepository('TestBundle:Produits')->findAll();
		
		return $this->render('default/grid.html.twig', array(
				'produits' => $produits,
				'paniers' => $paniers
		));
    }
}
