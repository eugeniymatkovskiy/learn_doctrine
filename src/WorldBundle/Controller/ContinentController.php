<?php

namespace WorldBundle\Controller;

use WorldBundle\Entity\Continent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Continent controller.
 *
 * @Route("continent")
 */
class ContinentController extends Controller
{
    /**
     * Lists all continent entities.
     *
     * @Route("/", name="continent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $continents = $em->getRepository('WorldBundle:Continent')->findAll();

        return $this->render('WorldBundle:Continent:index.html.twig', array(
            'continents' => $continents,
        ));
    }

    /**
     * Creates a new continent entity.
     *
     * @Route("/new", name="continent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $continent = new Continent();
        $form = $this->createForm('WorldBundle\Form\ContinentType', $continent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($continent);
            $em->flush();

            return $this->redirectToRoute('continent_show', array('id' => $continent->getId()));
        }

        return $this->render('WorldBundle:Continent:new.html.twig', array(
            'continent' => $continent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a continent entity.
     *
     * @Route("/{id}", name="continent_show")
     * @Method("GET")
     */
    public function showAction(Continent $continent)
    {
        $deleteForm = $this->createDeleteForm($continent);

        return $this->render('WorldBundle:Continent:show.html.twig', array(
            'continent' => $continent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing continent entity.
     *
     * @Route("/{id}/edit", name="continent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Continent $continent)
    {
        $deleteForm = $this->createDeleteForm($continent);
        $editForm = $this->createForm('WorldBundle\Form\ContinentType', $continent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('continent_edit', array('id' => $continent->getId()));
        }

        return $this->render('WorldBundle:Continent:edit.html.twig', array(
            'continent' => $continent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a continent entity.
     *
     * @Route("/{id}", name="continent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Continent $continent)
    {
        $form = $this->createDeleteForm($continent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($continent);
            $em->flush();
        }

        return $this->redirectToRoute('continent_index');
    }

    /**
     * Creates a form to delete a continent entity.
     *
     * @param Continent $continent The continent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Continent $continent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('continent_delete', array('id' => $continent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
