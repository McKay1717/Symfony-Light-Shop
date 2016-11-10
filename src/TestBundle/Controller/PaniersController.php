<?php

namespace TestBundle\Controller;

use TestBundle\Entity\Paniers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Panier controller.
 *
 * @Route("paniers")
 */
class PaniersController extends Controller
{
    /**
     * Lists all panier entities.
     *
     * @Route("/", name="paniers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paniers = $em->getRepository('TestBundle:Paniers')->findAll();

        return $this->render('paniers/index.html.twig', array(
            'paniers' => $paniers,
        ));
    }

    /**
     * Creates a new panier entity.
     *
     * @Route("/new", name="paniers_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $panier = new Paniers();
        $form = $this->createForm('TestBundle\Form\PaniersType', $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($panier);
            $em->flush($panier);

            return $this->redirectToRoute('paniers_show', array('id' => $panier->getId()));
        }

        return $this->render('paniers/new.html.twig', array(
            'panier' => $panier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a panier entity.
     *
     * @Route("/{id}", name="paniers_show")
     * @Method("GET")
     */
    public function showAction(Paniers $panier)
    {
        $deleteForm = $this->createDeleteForm($panier);

        return $this->render('paniers/show.html.twig', array(
            'panier' => $panier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing panier entity.
     *
     * @Route("/{id}/edit", name="paniers_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Paniers $panier)
    {
        $deleteForm = $this->createDeleteForm($panier);
        $editForm = $this->createForm('TestBundle\Form\PaniersType', $panier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paniers_edit', array('id' => $panier->getId()));
        }

        return $this->render('paniers/edit.html.twig', array(
            'panier' => $panier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a panier entity.
     *
     * @Route("/{id}", name="paniers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Paniers $panier)
    {
        $form = $this->createDeleteForm($panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($panier);
            $em->flush($panier);
        }

        return $this->redirectToRoute('paniers_index');
    }

    /**
     * Creates a form to delete a panier entity.
     *
     * @param Paniers $panier The panier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paniers $panier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paniers_delete', array('id' => $panier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
