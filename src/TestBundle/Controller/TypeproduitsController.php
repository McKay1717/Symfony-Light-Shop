<?php

namespace TestBundle\Controller;

use TestBundle\Entity\Typeproduits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeproduit controller.
 *
 * @Route("typeproduits")
 */
class TypeproduitsController extends Controller
{
    /**
     * Lists all typeproduit entities.
     *
     * @Route("/", name="typeproduits_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeproduits = $em->getRepository('TestBundle:Typeproduits')->findAll();

        return $this->render('typeproduits/index.html.twig', array(
            'typeproduits' => $typeproduits,
        ));
    }

    /**
     * Creates a new typeproduit entity.
     *
     * @Route("/new", name="typeproduits_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeproduit = new Typeproduit();
        $form = $this->createForm('TestBundle\Form\TypeproduitsType', $typeproduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeproduit);
            $em->flush($typeproduit);

            return $this->redirectToRoute('typeproduits_show', array('id' => $typeproduit->getId()));
        }

        return $this->render('typeproduits/new.html.twig', array(
            'typeproduit' => $typeproduit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeproduit entity.
     *
     * @Route("/{id}", name="typeproduits_show")
     * @Method("GET")
     */
    public function showAction(Typeproduits $typeproduit)
    {
        $deleteForm = $this->createDeleteForm($typeproduit);

        return $this->render('typeproduits/show.html.twig', array(
            'typeproduit' => $typeproduit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeproduit entity.
     *
     * @Route("/{id}/edit", name="typeproduits_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typeproduits $typeproduit)
    {
        $deleteForm = $this->createDeleteForm($typeproduit);
        $editForm = $this->createForm('TestBundle\Form\TypeproduitsType', $typeproduit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeproduits_edit', array('id' => $typeproduit->getId()));
        }

        return $this->render('typeproduits/edit.html.twig', array(
            'typeproduit' => $typeproduit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeproduit entity.
     *
     * @Route("/{id}", name="typeproduits_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typeproduits $typeproduit)
    {
        $form = $this->createDeleteForm($typeproduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeproduit);
            $em->flush($typeproduit);
        }

        return $this->redirectToRoute('typeproduits_index');
    }

    /**
     * Creates a form to delete a typeproduit entity.
     *
     * @param Typeproduits $typeproduit The typeproduit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typeproduits $typeproduit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typeproduits_delete', array('id' => $typeproduit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
