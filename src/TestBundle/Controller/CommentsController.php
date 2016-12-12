<?php

namespace TestBundle\Controller;

use TestBundle\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Comment controller.
 *
 * @Route("comments")
 */
class CommentsController extends Controller {
	/**
	 * Lists all comment entities.
	 *
	 * @Route("/", name="comments_index")
	 *
	 * @method ("GET")
	 */
	public function indexAction() {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$em = $this->getDoctrine ()->getManager ();
		
		$comments = $em->getRepository ( 'TestBundle:Comments' )->findAll ();
		
		return $this->render ( 'comments/index.html.twig', array (
				'comments' => $comments 
		) );
	}
	
	/**
	 * Creates a new comment entity.
	 *
	 * @Route("/new", name="comments_new")
	 *
	 * @method ({"POST"})
	 */
	public function newAction(Request $request) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'IS_AUTHENTICATED_FULLY' )) {
			throw $this->createAccessDeniedException ();
		}
		$em = $this->getDoctrine ()->getManager ();
		$session = new Session();
		$session->migrate ();
		$lp = $session->get ( 'lp' );
		$product = $em->getRepository ( 'TestBundle:Produits' )->findOneById ( $lp );
		$comment = new Comments ();
		$form = $this->createForm ( 'TestBundle\Form\CommentsType', $comment );
		$form->handleRequest ( $request );
		$user = $this->get ( 'security.token_storage' )->getToken ()->getUser ();
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$comment->setUser ( $user );
			$comment->setProduct($product);
			$em->persist ( $comment );
			$em->flush ( $comment );
			
			return $this->redirectToRoute ( 'comments_show', array (
					'id' => $comment->getId () 
			) );
		}
		
		return $this->render ( 'comments/new.html.twig', array (
				'comment' => $comment,
				'form' => $form->createView () 
		) );
	}
	
	/**
	 * Finds and displays a comment entity.
	 *
	 * @Route("/{id}", name="comments_show")
	 *
	 * @method ("GET")
	 */
	public function showAction(Comments $comment) {
		if ($this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			$deleteForm = $this->createDeleteForm ( $comment )->createView ();
		} else {
			$deleteForm = '';
		}
		
		return $this->render ( 'comments/show.html.twig', array (
				'comment' => $comment,
				'delete_form' => $deleteForm 
		) );
	}
	
	/**
	 * Displays a form to edit an existing comment entity.
	 *
	 * @Route("/{id}/edit", name="comments_edit")
	 *
	 * @method ({"GET", "POST"})
	 */
	public function editAction(Request $request, Comments $comment) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$deleteForm = $this->createDeleteForm ( $comment );
		$editForm = $this->createForm ( 'TestBundle\Form\CommentsType', $comment );
		$editForm->handleRequest ( $request );
		
		if ($editForm->isSubmitted () && $editForm->isValid ()) {
			$this->getDoctrine ()->getManager ()->flush ();
			
			return $this->redirectToRoute ( 'comments_edit', array (
					'id' => $comment->getId () 
			) );
		}
		
		return $this->render ( 'comments/edit.html.twig', array (
				'comment' => $comment,
				'edit_form' => $editForm->createView (),
				'delete_form' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Deletes a comment entity.
	 *
	 * @Route("/{id}", name="comments_delete")
	 *
	 * @method ("DELETE")
	 */
	public function deleteAction(Request $request, Comments $comment) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$form = $this->createDeleteForm ( $comment );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->remove ( $comment );
			$em->flush ( $comment );
		}
		
		return $this->redirectToRoute ( 'comments_index' );
	}
	
	/**
	 * Creates a form to delete a comment entity.
	 *
	 * @param Comments $comment
	 *        	The comment entity
	 *        	
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Comments $comment) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		return $this->createFormBuilder ()->setAction ( $this->generateUrl ( 'comments_delete', array (
				'id' => $comment->getId () 
		) ) )->setMethod ( 'DELETE' )->getForm ();
	}
}
