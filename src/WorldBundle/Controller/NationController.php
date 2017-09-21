<?php

namespace WorldBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use WorldBundle\Entity\Nation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use WorldBundle\Repository\CountryRepository;

/**
 * Nation controller.
 *
 * @Route("nation")
 */
class NationController extends Controller
{
    /**
     * Lists all nation entities.
     *
     * @Route("/", name="nation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nations = $em->getRepository('WorldBundle:Nation')->findAll();

        return $this->render('nation/index.html.twig', array(
            'nations' => $nations,
        ));
    }

    /**
     * Creates a new nation entity.
     *
     * @Route("/new", name="nation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $nation = new Nation();
        $form = $this->createForm('WorldBundle\Form\NationType', $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nation);
            $em->flush();

            return $this->redirectToRoute('nation_show', array('id' => $nation->getId()));
        }

        return $this->render('nation/new.html.twig', array(
            'nation' => $nation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a nation entity.
     *
     * @Route("/{id}", name="nation_show")
     * @Method("GET")
     */
    public function showAction(Nation $nation)
    {


        $deleteForm = $this->createDeleteForm($nation);

        return $this->render('nation/show.html.twig', array(
            'nation' => $nation,
            'countries' => $nation->getCountries(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing nation entity.
     *
     * @Route("/{id}/edit", name="nation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Nation $nation)
    {
        $deleteForm = $this->createDeleteForm($nation);
        $editForm = $this->createForm('WorldBundle\Form\NationType', $nation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nation_edit', array('id' => $nation->getId()));
        }

        return $this->render('nation/edit.html.twig', array(
            'nation' => $nation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a nation entity.
     *
     * @Route("/{id}", name="nation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Nation $nation)
    {
        $form = $this->createDeleteForm($nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nation);
            $em->flush();
        }

        return $this->redirectToRoute('nation_index');
    }

    /**
     * Creates a form to delete a nation entity.
     *
     * @param Nation $nation The nation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Nation $nation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nation_delete', array('id' => $nation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
