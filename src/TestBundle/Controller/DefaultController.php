<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TestBundle\Entity\Paniers;
use TestBundle\Entity\Produits;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="index")
	 *
	 * @method ({"GET"})
	 */
	public function indexAction() {
		$em = $this->getDoctrine ()->getManager ();
		
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findAll ();
		$produits = $em->getRepository ( 'TestBundle:Produits' )->findAll ();
		
		$del = array ();
		foreach ( $paniers as $entity ) {
			$del [$entity->getId ()] = $this->forward ( 'TestBundle:Paniers:generateDeleteButton', array (
					'panier' => $entity 
			) )->getContent ();
		}
		
		return $this->render ( 'default/grid.html.twig', array (
				'produits' => $produits,
				'paniers' => $paniers,
				'del' => $del 
		) );
	}
}
