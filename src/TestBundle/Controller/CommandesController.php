<?php

namespace TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TestBundle\Entity\Commandes;
use TestBundle\Form\CommandesType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
		$em = $this->getDoctrine ()->getManager ();
		
		$commandes = $em->getRepository ( 'TestBundle:Commandes' )->findAll ();
		
		return $this->render ( 'commandes/index.html.twig', array (
				'commandes' => $commandes 
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
	 * @method ({"GET", "POST"})
	 */
	public function validCardAction(Request $request) {
		$commande = new Commandes ();
		$em = $this->getDoctrine ()->getManager ();
		$commande->setDateAchat ( new \DateTime () );
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findAll ();
		foreach ( $paniers as $entity ) {
			if ($entity->getCommande () != null) {
				$commande->setPrix ( $commande->getPrix () + $entity->getPrix () );
				$commande->setUser ( $entity->getUser () );
			}
		}
		$commande->setEtat ( $em->getRepository ( 'TestBundle:Etats' )->findOneByLibelle ( "A préparer" ) );
		
		$form = $this->createFormBuilder ( $commande )->setAction ( $this->generateUrl ( 'commandes_valid' ) )->setMethod ( "POST" )->getForm ();
		$form->handleRequest ( $request );
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $commande );
			$em->flush ();
			
			foreach ( $paniers as $entity ) {
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
		$deleteForm = $this->createDeleteForm ( $commande );
		
		return $this->render ( 'commandes/show.html.twig', array (
				'commande' => $commande,
				'delete_form' => $deleteForm->createView () 
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
		return $this->createFormBuilder ()->setAction ( $this->generateUrl ( 'commandes_delete', array (
				'id' => $commande->getId () 
		) ) )->setMethod ( 'DELETE' )->getForm ();
	}
}
