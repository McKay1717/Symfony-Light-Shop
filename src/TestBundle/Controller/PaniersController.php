<?php

namespace TestBundle\Controller;

use TestBundle\Entity\Paniers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Produits;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\HttpFoundation\Response;

/**
 * Panier controller.
 *
 * @Route("paniers")
 */
class PaniersController extends Controller {
	/**
	 * Lists all panier entities.
	 *
	 * @Route("/", name="paniers_index")
	 *
	 * @method ("GET")
	 */
	public function indexAction() {
		$em = $this->getDoctrine ()->getManager ();
		
		$paniers = $em->getRepository ( 'TestBundle:Paniers' )->findByUser($this->get('security.token_storage')->getToken()->getUser());
		
		return $this->render ( 'paniers/index.html.twig', array (
				'paniers' => $paniers 
		) );
	}
	
	/**
	 * Creates a new panier entity.
	 *
	 * @Route("/new", name="paniers_new")
	 *
	 * @method ({"GET", "POST"})
	 */
	public function newAction(Request $request) {
		$panier = new Paniers ();
		$form = $this->createForm ( 'TestBundle\Form\PaniersType', $panier );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $panier );
			$em->flush ( $panier );
			
			return $this->redirectToRoute ( 'paniers_show', array (
					'id' => $panier->getId () 
			) );
		}
		
		return $this->render ( 'paniers/new.html.twig', array (
				'panier' => $panier,
				'form' => $form->createView () 
		) );
	}
	/**
	 * @Route("/{id}", name="addtocard")
	 *
	 * @method ({"POST"})
	 */
	public function addToCardAction(Produits $produit, Request $request) {
		$count = 0 + $request->request->get ( 'many' );
		$validator = $this->get ( 'validator' );
		$errors = $validator->validate ( $count, array (
				new NotBlank (),
				new Range ( array (
						'min' => 1,
						'max' => $produit->getStock () 
				) ) 
		) );
		
		if (count ( $errors ) <= 0) {
			
			$user = $this->get('security.token_storage')->getToken()->getUser();
			
			$tmp = $this->getDoctrine ()->getRepository ( 'TestBundle:Paniers' )->findByProduit ( $produit );
			foreach ( $tmp as $entity ) {
				if ($entity->getUser () == $user && $entity->getCommande () == null)
					$panier = $entity;
			}
			if (empty ( $panier )) {
				$panier = new Paniers ();
				$panier->setUser ( $user );
				$panier->setDateajoutpanier ( new \DateTime () );
				if ($panier->getQuantite () + $count <= $produit->getStock ())
					$panier->setQuantite ( $count );
				$panier->setProduit ( $produit );
				$panier->setPrix ( $produit->getPrix () * $panier->getQuantite () );
			} else {
				if ($panier->getQuantite () + $count <= $produit->getStock ())
					$panier->setQuantite ( $panier->getQuantite () + $count );
				$panier->setPrix ( $produit->getPrix () * $panier->getQuantite () );
			}
			
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $panier );
			$em->flush ( $panier );
		} else {
			$response = new Response ();
			$response->setStatusCode ( 400 );
			$response->setContent ( $errors );
			return $response;
		}
		
		return $this->redirectToRoute ( 'index' );
	}
	
	/**
	 * Finds and displays a panier entity.
	 *
	 * @Route("/{id}", name="paniers_show")
	 *
	 * @method ("GET")
	 */
	public function showAction(Paniers $panier) {
		$deleteForm = $this->createDeleteForm ( $panier );
		
		return $this->render ( 'paniers/show.html.twig', array (
				'panier' => $panier,
				'delete_form' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Finds and displays a panier entity.
	 *
	 * @Route("/delbutton/{id}", name="paniers_del")
	 *
	 * @method ("GET")
	 */
	public function generateDeleteButtonAction(Paniers $panier) {
		$deleteForm = $this->createDeleteForm ( $panier );
		return $this->render ( 'paniers/delete.html.twig', array (
				'del' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Displays a form to edit an existing panier entity.
	 *
	 * @Route("/{id}/edit", name="paniers_edit")
	 *
	 * @method ({"GET", "POST"})
	 */
	public function editAction(Request $request, Paniers $panier) {
		$deleteForm = $this->createDeleteForm ( $panier );
		$editForm = $this->createForm ( 'TestBundle\Form\PaniersType', $panier );
		$editForm->handleRequest ( $request );
		
		if ($editForm->isSubmitted () && $editForm->isValid ()) {
			$this->getDoctrine ()->getManager ()->flush ();
			
			return $this->redirectToRoute ( 'paniers_edit', array (
					'id' => $panier->getId () 
			) );
		}
		
		return $this->render ( 'paniers/edit.html.twig', array (
				'panier' => $panier,
				'edit_form' => $editForm->createView (),
				'delete_form' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Deletes a panier entity.
	 *
	 * @Route("/delete/{id}", name="paniers_delete")
	 *
	 * @method ({"DELETE"})
	 */
	public function deleteAction(Request $request, Paniers $panier) {
		$form = $this->createDeleteForm ( $panier );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			
			$em = $this->getDoctrine ()->getManager ();
			
			$em->remove ( $panier );
			
			$em->flush ( $panier );
		}
		
		return $this->redirectToRoute ( 'index' );
	}
	
	/**
	 * Creates a form to delete a panier entity.
	 *
	 * @param Paniers $panier
	 *        	The panier entity
	 *        	
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Paniers $panier) {
		return $this->createFormBuilder ()->setAction ( $this->generateUrl ( 'paniers_delete', array (
				'id' => $panier->getId () 
		) ) )->setMethod ( 'DELETE' )->getForm ();
	}
}
