<?php

namespace TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TestBundle\Entity\Commandes;
use TestBundle\Form\CommandesType;

/**
 * Commandes controller.
 *
 * @Route("/commandes")
 */
class CommandesController extends Controller
{
    /**
     * Lists all Commandes entities.
     *
     * @Route("/", name="commandes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('TestBundle:Commandes')->findAll();

        return $this->render('commandes/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new Commandes entity.
     *
     * @Route("/new", name="commandes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commande = new Commandes();
        $form = $this->createForm('TestBundle\Form\CommandesType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commandes_show', array('id' => $commande->getId()));
        }

        return $this->render('commandes/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Commandes entity.
     *
     * @Route("/{id}", name="commandes_show")
     * @Method("GET")
     */
    public function showAction(Commandes $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commandes/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Commandes entity.
     *
     * @Route("/{id}/edit", name="commandes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commandes $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('TestBundle\Form\CommandesType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commandes_edit', array('id' => $commande->getId()));
        }

        return $this->render('commandes/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Commandes entity.
     *
     * @Route("/{id}", name="commandes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commandes $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commandes_index');
    }

    /**
     * Creates a form to delete a Commandes entity.
     *
     * @param Commandes $commande The Commandes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commandes $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commandes_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
