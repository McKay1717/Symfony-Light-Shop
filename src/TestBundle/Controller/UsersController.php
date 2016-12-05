<?php

namespace TestBundle\Controller;

use TestBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("users")
 */
class UsersController extends Controller {
	/**
	 * Lists all user entities.
	 *
	 * @Route("/", name="users_index")
	 * 
	 * @method ("GET")
	 */
	public function indexAction() {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$em = $this->getDoctrine ()->getManager ();
		
		$users = $em->getRepository ( 'TestBundle:Users' )->findAll ();
		
		return $this->render ( 'users/index.html.twig', array (
				'users' => $users 
		) );
	}
	
	/**
	 * Creates a new user entity.
	 *
	 * @Route("/new", name="users_new")
	 * 
	 * @method ({"GET", "POST"})
	 */
	public function newAction(Request $request) {

		$user = new Users ();
		$form = $this->createForm ( 'TestBundle\Form\UsersType', $user);
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
			$user->setPassword($password);
			$em = $this->getDoctrine ()->getManager ();
			$em->persist ( $user );
			$em->flush ( $user );
			
			return $this->redirectToRoute ( 'users_show', array (
					'id' => $user->getId () 
			) );
		}
		
		return $this->render ( 'users/new.html.twig', array (
				'user' => $user,
				'form' => $form->createView () 
		) );
	}
	
	/**
	 * Finds and displays a user entity.
	 *
	 * @Route("/{id}", name="users_show")
	 * 
	 * @method ("GET")
	 */
	public function showAction(Users $user) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$deleteForm = $this->createDeleteForm ( $user );
		
		return $this->render ( 'users/show.html.twig', array (
				'user' => $user,
				'delete_form' => $deleteForm->createView () 
		) );
	}
	
	/**
	 * Displays a form to edit an existing user entity.
	 *
	 * @Route("/{id}/edit", name="users_edit")
	 * 
	 * @method ({"GET", "POST"})
	 */
	public function editAction(Request $request, Users $user) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$deleteForm = $this->createDeleteForm ( $user );
		$editForm = $this->createForm ( 'TestBundle\Form\UsersType', $user );
		$editForm->handleRequest ( $request );
		
		if ($editForm->isSubmitted () && $editForm->isValid ()) {
			$this->getDoctrine ()->getManager ()->flush ();
			
			return $this->redirectToRoute ( 'users_edit', array (
					'id' => $user->getId () 
			) );
		}
		
		return $this->render ( 'users/edit.html.twig', array (
				'user' => $user,
				'edit_form' => $editForm->createView (),
				'delete_form' => $deleteForm->createView () 
		) );
	}
	/**
	 * Displays a form to edit an existing user entity.
	 *
	 * @Route("/{id}/editUser", name="users_edituser")
	 * 
	 * @method ({"GET", "POST"})
	 */
	public function edituserAction(Request $request, Users $user) {
		if ($this->get ( 'security.token_storage' )->getToken ()->getUser () != $user) {
			throw $this->createAccessDeniedException ();
		}
		$editForm = $this->createForm ( 'TestBundle\Form\UsersType', $user );
		
		$editForm->handleRequest ( $request );
		
		if ($editForm->isSubmitted () && $editForm->isValid ()) {
			$this->getDoctrine ()->getManager ()->flush ();
			
			return $this->redirectToRoute ( 'users_edituser', array (
					'id' => $user->getId () 
			) );
		}
		
		return $this->render ( 'users/edituser.html.twig', array (
				'user' => $user,
				'edit_form' => $editForm->createView () 
		) );
	}
	
	/**
	 * Deletes a user entity.
	 *
	 * @Route("/{id}", name="users_delete")
	 * 
	 * @method ("DELETE")
	 */
	public function deleteAction(Request $request, Users $user) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException ();
		}
		$form = $this->createDeleteForm ( $user );
		$form->handleRequest ( $request );
		
		if ($form->isSubmitted () && $form->isValid ()) {
			$em = $this->getDoctrine ()->getManager ();
			$em->remove ( $user );
			$em->flush ( $user );
		}
		
		return $this->redirectToRoute ( 'users_index' );
	}
	
	/**
	 * Creates a form to delete a user entity.
	 *
	 * @param Users $user
	 *        	The user entity
	 *        	
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Users $user) {
		if (! $this->get ( 'security.authorization_checker' )->isGranted ( 'ROLE_ADMIN' )) {
			throw $this->createAccessDeniedException();
    	}
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
