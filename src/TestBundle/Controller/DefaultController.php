<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TestBundle\Entity\Paniers;
use TestBundle\Entity\Produits;
use TestBundle\Entity\Users;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="index")
	 *
	 * @method ({"GET"})
	 */
	public function indexAction() {
		
		$em = $this->getDoctrine ()->getManager ();
		
		
		
		$paniers = $em->getRepository('TestBundle:Paniers')->findAll();
		$produits = $em->getRepository ( 'TestBundle:Produits' )->findAll ();
		
		return $this->render ( 'default/grid.html.twig', array (
				'produits' => $produits,
				'paniers' => $paniers 
		) );
	}
	/**
	 * @Route("/{id}", name="addtocard")
	 *
	 * @method ({"GET"})
	 */
	public function addToCardAction(Produits $produit) {
		$panier = new Paniers ();
		$user = $this->getDoctrine ()->getRepository ( 'TestBundle:Users' )->findOneById ( 1 );
		
		$panier->setUser ( $user );
		$panier->setDateajoutpanier ( new \DateTime () );
		$panier->setPrix ( $produit->getPrix () );
		$panier->setQuantite ( 1 );
		$panier->setProduit ( $produit );
		
		$em = $this->getDoctrine ()->getManager ();
		$em->persist ( $panier );
		$em->flush ( $panier );
		
		return $this->redirectToRoute('index');
	}
}
