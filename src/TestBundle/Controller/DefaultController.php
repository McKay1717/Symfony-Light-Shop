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
		
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findAll ();
		$produits = $em->getRepository ( 'TestBundle:Produits' )->findAll ();
		
		return $this->render ( 'default/grid.html.twig', array (
				'produits' => $produits,
				'paniers' => $paniers 
		) );
	}
	/**
	 * @Route("/{id}", name="addtocard")
	 *
	 * @method ({"POST"})
	 */
	public function addToCardAction(Produits $produit) {
		$user = $this->getDoctrine ()->getRepository ( 'TestBundle:Users' )->findOneById ( 1 );
		try {
			$panier = $this->getDoctrine ()->getRepository ( 'TestBundle:Paniers' )->findOneByProduit($produit);
		} catch ( Exception $e ) {
			$panier = new Paniers ();
		}
		if(empty($panier))
		{
			$panier = new Paniers();
			$panier->setUser ( $user );
			$panier->setDateajoutpanier ( new \DateTime () );
			$panier->setPrix ( $produit->getPrix () );
			$panier->setQuantite ( 1 );
			$panier->setProduit ( $produit );
		}else
		{
			$panier->setQuantite($panier->getQuantite()+1);
		}
	
		
		$em = $this->getDoctrine ()->getManager ();
		$em->persist ( $panier );
		$em->flush ( $panier );
		
		return $this->redirectToRoute ( 'index' );
	}
}
