<?php

namespace TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TestBundle\Entity\Etats;
use TestBundle\Form\EtatsType;

/**
 * Etats controller.
 *
 * @Route("/etats")
 */
class EtatsController extends Controller
{
    /**
     * Lists all Etats entities.
     *
     * @Route("/", name="etats_index")
     * @Method("GET")
     */
    public function indexAction()
    {
    	if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    		throw $this->createAccessDeniedException();
    	}
        $em = $this->getDoctrine()->getManager();

        $etats = $em->getRepository('TestBundle:Etats')->findAll();

        return $this->render('etats/index.html.twig', array(
            'etats' => $etats,
        ));
    }

    /**
     * Creates a new Etats entity.
     *
     * @Route("/new", name="etats_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    		throw $this->createAccessDeniedException();
    	}
        $etat = new Etats();
        $form = $this->createForm('TestBundle\Form\EtatsType', $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etat);
            $em->flush();

            return $this->redirectToRoute('etats_show', array('id' => $etat->getId()));
        }

        return $this->render('etats/new.html.twig', array(
            'etat' => $etat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Etats entity.
     *
     * @Route("/{id}", name="etats_show")
     * @Method("GET")
     */
    public function showAction(Etats $etat)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    		throw $this->createAccessDeniedException();
    	}
        $deleteForm = $this->createDeleteForm($etat);

        return $this->render('etats/show.html.twig', array(
            'etat' => $etat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Etats entity.
     *
     * @Route("/{id}/edit", name="etats_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etats $etat)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    		throw $this->createAccessDeniedException();
    	}
        $deleteForm = $this->createDeleteForm($etat);
        $editForm = $this->createForm('TestBundle\Form\EtatsType', $etat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etat);
            $em->flush();

            return $this->redirectToRoute('etats_edit', array('id' => $etat->getId()));
        }

        return $this->render('etats/edit.html.twig', array(
            'etat' => $etat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Etats entity.
     *
     * @Route("/{id}", name="etats_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etats $etat)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    		throw $this->createAccessDeniedException();
    	}
        $form = $this->createDeleteForm($etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etat);
            $em->flush();
        }

        return $this->redirectToRoute('etats_index');
    }

    /**
     * Creates a form to delete a Etats entity.
     *
     * @param Etats $etat The Etats entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etats $etat)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    		throw $this->createAccessDeniedException();
    	}
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etats_delete', array('id' => $etat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
