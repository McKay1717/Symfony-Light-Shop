<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TestBundle\Entity\Paniers;
use TestBundle\Entity\Produits;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Commandes;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="index")
	 *
	 * @method ({"GET"})
	 */
	public function indexAction(Request $request) {
		$em = $this->getDoctrine ()->getManager ();
		
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findByUser ( $this->get ( 'security.token_storage' )->getToken ()->getUser () );
		$produits = $em->getRepository ( 'TestBundle:Produits' )->findAll ();
		$typeproduit = $em->getRepository ( "TestBundle:Typeproduits" )->findAll ();
		
		foreach ( $paniers as $panier ) {
			if ($panier->getDateajoutpanier ()->diff ( new \DateTime ( "now" ) )->i >= 15) {
				$em->remove ( $panier );
				$em->flush ( $panier );
			}
		}
		$tmp = array ();
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findByUser ( $this->get ( 'security.token_storage' )->getToken ()->getUser () );
		foreach ( $paniers as $panier ) {
			if ($panier->getCommande () == null)
				array_push ( $tmp, $panier );
		}
		$paniers = $tmp;
		$del = array ();
		$commandeButton = "";
		if ($this->get ( 'security.authorization_checker' )->isGranted ( 'IS_AUTHENTICATED_FULLY' )) {
			foreach ( $paniers as $entity ) {
				$del [$entity->getId ()] = $this->forward ( 'TestBundle:Paniers:generateDeleteButton', array (
						'panier' => $entity 
				) )->getContent ();
			}
			
			$commandeButton = $this->forward ( 'TestBundle:Commandes:validCard', array (
					'request' => $request,
					'internalcall' => true 
			) )->getContent ();
		}
		if (count($paniers) <= 0)
		{
			$commandeButton = "";
		}
		return $this->render ( 'default/grid.html.twig', array (
				'produits' => $produits,
				'paniers' => $paniers,
				'del' => $del,
				'tp' => $typeproduit, 
				'commander' => $commandeButton
		) );
	}
}
