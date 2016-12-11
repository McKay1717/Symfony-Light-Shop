<?php

namespace TestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Commandes;
use TestBundle\Form\CommandesType;

/**
 * Commandes controller.
 *
 * @Route("/commandes")
 */
class CommandesController extends Controller {
	/**
	 * Lists all Commandes entities.
	 *
	 * @Route("/", name="commandes_index")
	 *
	 * @method ("GET")
	 */
	public function indexAction() {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException();
		}
		$em = $this->getDoctrine ()->getManager ();
		
		$commandes = $em->getRepository ( 'TestBundle:Commandes' )->findAll ();
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findAll();
		
		return $this->render ( 'commandes/index.html.twig', array (
				'commandes' => $commandes,
				'paniers' => $paniers
		) );
	}
	
	/**
	 * Lists all Commandes entities by user.
	 *
	 * @Route("/user", name="commandes_user")
	 *
	 * @method ("GET")
	 */
	public function indexUserComandeAction() {
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw $this->createAccessDeniedException();
		}
		$em = $this->getDoctrine ()->getManager ();
		
	
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$commandes = $em->getRepository ( 'TestBundle:Commandes' )->findByUser($user);
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findByUser($user);
	
		return $this->render ( 'commandes/index.html.twig', array (
				'commandes' => $commandes,
				'paniers' => $paniers
		) );
	}
	
	
	/**
	 * Creates a new Commandes entity.
	 *
	 * @Route("/new", name="commandes_new")
	 *
	 * @method ({"GET", "POST"})
	 */
	public function newAction(Request $request) {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException();
		}
		$commande = new Commandes ();
		$form = $this->createForm ( 'TestBundle\Form\CommandesType', $commande );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $commande );
			$em->flush ();
			
			return $this->redirectToRoute ( 'commandes_show', array (
					'id' => $commande->getId () 
			) );
		}
		
		return $this->render ( 'commandes/new.html.twig', array (
				'commande' => $commande,
				'form' => $form->createView () 
		) );
	}
	/**
	 * Creates a new Commandes entity.
	 *
	 * @Route("/validcard", name="commandes_valid")
	 *
	 * @method ({"GET","POST"})
	 */
	public function validCardAction(Request $request) {
		

		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw $this->createAccessDeniedException();
		}
		$commande = new Commandes ();
		$em = $this->getDoctrine ()->getManager ();
		$commande->setDateAchat ( new \DateTime () );
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findByUser($user);
		$count = 0;
		$panier = array();
		foreach ( $paniers as $entity ) {
			if ($entity->getCommande () == null) {
				$commande->setPrix ( $commande->getPrix () + $entity->getPrix () );
				$commande->setUser ( $entity->getUser () );
				array_push($panier, $entity);
				$count ++;
			}
		}
		//if($count )
		
		$commande->setEtat ( $em->getRepository ( 'TestBundle:Etats' )->findOneByLibelle ( "A préparer" ) );
		
		$form = $this->createFormBuilder ( $commande )->setAction ( $this->generateUrl ( 'commandes_valid' ) )->setMethod ( "POST" )->getForm ();
		$form->handleRequest ( $request );
		if ($form->isSubmitted () && $form->isValid () && $count > 0) {
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $commande );
			$em->flush ();
			
			foreach ( $panier as $entity ) {
				$entity->setCommande ( $commande );
				$produit = $entity->getProduit ();
				$produit->setStock ( $produit->getStock () - $entity->getQuantite () );
				$em->persist ( $entity );
				$em->persist ( $produit );
			}
			$em->flush ();
			return $this->redirectToRoute ( 'index' );
		}
		
		return $this->render ( 'commandes/form.html.twig', array (
				'form' => $form->createView () 
		) );
	}
	
	/**
	 * Finds and displays a Commandes entity.
	 *
	 * @Route("/{id}", name="commandes_show")
	 *
	 * @method ("GET")
	 */
	public function showAction(Commandes $commande) {
		$em = $this->getDoctrine ()->getManager ();
		if ( $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			$deleteForm = $this->createDeleteForm ( $commande )->createView () ;
		}else {
			$deleteForm = "";
		}
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findAll();
		$produits = $em->getRepository ( 'TestBundle:Produits' )->findAll();
		return $this->render ( 'commandes/show.html.twig', array (
				'commande' => $commande,
				'delete_form' => $deleteForm,
				'paniers' => $paniers,
				'produits' => $produits
		) );
	}
	
	/**
	 * Displays a form to edit an existing Commandes entity.
	 *
	 * @Route("/{id}/edit", name="commandes_edit")
	 *
	 * @method ({"GET", "POST"})
	 */
	public function editAction(Request $request, Commandes $commande) {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException();
		}
		$deleteForm = $this->createDeleteForm ( $commande );
		$editForm = $this->createForm ( 'TestBundle\Form\CommandesType', $commande );
		$editForm->handleRequest ( $request );
		
		if ($editForm->isSubmitted () && $editForm->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $commande );
			$em->flush ();
			
			return $this->redirectToRoute ( 'commandes_edit', array (
					'id' => $commande->getId () 
			) );
		}
		
		return $this->render ( 'commandes/edit.html.twig', array (
				'commande' => $commande,
				'edit_form' => $editForm->createView (),
				'delete_form' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Deletes a Commandes entity.
	 *
	 * @Route("/{id}", name="commandes_delete")
	 *
	 * @method ("DELETE")
	 */
	public function deleteAction(Request $request, Commandes $commande) {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException();
		}
		$form = $this->createDeleteForm ( $commande );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->remove ( $commande );
			$em->flush ();
		}
		
		return $this->redirectToRoute ( 'commandes_index' );
	}
	
	/**
	 * Creates a form to delete a Commandes entity.
	 *
	 * @param Commandes $commande
	 *        	The Commandes entity
	 *        	
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Commandes $commande) {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			throw $this->createAccessDeniedException();
		}
		return $this->createFormBuilder ()->setAction ( $this->generateUrl ( 'commandes_delete', array (
				'id' => $commande->getId () 
		) ) )->setMethod ( 'DELETE' )->getForm ();
	}
}
