<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TestBundle\Entity\Paniers;
use TestBundle\Entity\Produits;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="index")
	 * 
	 * @method ({"GET","POST"})
	 */
	public function indexAction(Request $request) {
		$paniers = new Paniers ();
		$em = $this->getDoctrine()->getManager();
		
		$produits = $em->getRepository('TestBundle:Produits')->findAll();
		
		$panier = new Paniers();
		$form = $this->createForm('TestBundle\Form\PaniersType', $panier);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($panier);
			$em->flush($panier);
		
			return $this->redirectToRoute('index');
		}
		

		
		return $this->render('default/grid.html.twig', array(
				'produits' => $produits,
				'paniers' => $paniers,
				'form' => $form->createView()
		));
    }
}
