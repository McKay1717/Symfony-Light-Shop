<?php

namespace TestBundle\Controller;

use TestBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produit controller.
 *
 * @Route("produits")
 */
class ProduitsController extends Controller {
	
	/**
	 * Lists all produit entities.
	 *
	 * @Route("/", name="produits_index")
	 * 
	 * @method ("GET")
	 */
	public function indexAction() {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$em = $this->getDoctrine ()->getManager ();
		
		$produits = $em->getRepository ( 'TestBundle:Produits' )->findAll ();
		
		return $this->render ( 'produits/index.html.twig', array (
				'produits' => $produits 
		) );
	}
	
	/**
	 * Creates a new produit entity.
	 *
	 * @Route("/new", name="produits_new")
	 * 
	 * @method ({"GET", "POST"})
	 */
	public function newAction(Request $request) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$produit = new Produits ();
		$form = $this->createForm ( 'TestBundle\Form\ProduitsType', $produit );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $produit );
			$em->flush ( $produit );
			
			return $this->redirectToRoute ( 'produits_show', array (
					'id' => $produit->getId () 
			) );
		}
		
		return $this->render ( 'produits/new.html.twig', array (
				'produit' => $produit,
				'form' => $form->createView () 
		) );
	}
	
	/**
	 * Finds and displays a produit entity.
	 *
	 * @Route("/{id}", name="produits_show")
	 * 
	 * @method ("GET")
	 */
	public function showAction(Produits $produit) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$deleteForm = $this->createDeleteForm ( $produit );
		
		return $this->render ( 'produits/show.html.twig', array (
				'produit' => $produit,
				'delete_form' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Displays a form to edit an existing produit entity.
	 *
	 * @Route("/{id}/edit", name="produits_edit")
	 * 
	 * @method ({"GET", "POST"})
	 */
	public function editAction(Request $request, Produits $produit) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$deleteForm = $this->createDeleteForm ( $produit );
		$editForm = $this->createForm ( 'TestBundle\Form\ProduitsType', $produit );
		$editForm->handleRequest ( $request );
		
		if ($editForm->isSubmitted () && $editForm->isValid ()) {
			$this->getDoctrine ()->getManager ()->flush ();
			
			return $this->redirectToRoute ( 'produits_edit', array (
					'id' => $produit->getId () 
			) );
		}
		
		return $this->render ( 'produits/edit.html.twig', array (
				'produit' => $produit,
				'edit_form' => $editForm->createView (),
				'delete_form' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Deletes a produit entity.
	 *
	 * @Route("/{id}", name="produits_delete")
	 * 
	 * @method ("DELETE")
	 */
	public function deleteAction(Request $request, Produits $produit) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$form = $this->createDeleteForm ( $produit );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->remove ( $produit );
			$em->flush ( $produit );
		}
		
		return $this->redirectToRoute ( 'produits_index' );
	}
	
	/**
	 * Creates a form to delete a produit entity.
	 *
	 * @param Produits $produit
	 *        	The produit entity
	 *        	
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Produits $produit) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
    	}
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produits_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
