<?php

namespace WorldBundle\Controller;

use Doctrine\ORM\EntityManager;
use WorldBundle\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use WorldBundle\Entity\Nation;
use WorldBundle\Entity\NationsInCountries;

/**
 * Country controller.
 *
 * @Route("country")
 */
class CountryController extends Controller
{
    /**
     * Lists all country entities.
     *
     * @Route("/", name="country_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $countries = $em->getRepository('WorldBundle:Country')->findAll();

        return $this->render('WorldBundle:Country:index.html.twig', array(
            'countries' => $countries,
        ));
    }

    /**
     * Creates a new country entity.
     *
     * @Route("/new", name="country_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $country = new Country();
        $form = $this->createForm('WorldBundle\Form\CountryType', $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();

            return $this->redirectToRoute('country_show', array('id' => $country->getId()));
        }

        return $this->render('WorldBundle:Country:new.html.twig', array(
            'country' => $country,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a country entity.
     *
     * @Route("/{id}", name="country_show")
     * @Method("GET")
     */
    public function showAction(Country $country)
    {
        $deleteForm = $this->createDeleteForm($country);
	    $em = $this->getDoctrine()->getManager();
	    $allNations = $em->getRepository('WorldBundle:Nation')->findAll();

        return $this->render('WorldBundle:Country:show.html.twig', array(
            'country' => $country,
	        'allNations' => $allNations,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing country entity.
     *
     * @Route("/{id}/edit", name="country_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Country $country)
    {
        $deleteForm = $this->createDeleteForm($country);
        $editForm = $this->createForm('WorldBundle\Form\CountryType', $country);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('country_edit', array('id' => $country->getId()));
        }

        return $this->render('WorldBundle:Country:edit.html.twig', array(
            'country' => $country,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a country entity.
     *
     * @Route("/{id}", name="country_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Country $country)
    {
        $form = $this->createDeleteForm($country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($country);
            $em->flush();
        }

        return $this->redirectToRoute('country_index');
    }

    /**
     * Creates a form to delete a country entity.
     *
     * @param Country $country The country entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Country $country)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('country_delete', array('id' => $country->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

	/**
	 * @Route("/add/nation", name="add_nation_to_country")
	 * @Method({"POST"})
	 */
	public function addNationAction(Request $request) {
		$countryId = $request->request->get('country');
		$nationId = $request->request->get('nation');
		$population = $request->request->get('population');

		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();

		/** @var Country $country */
		$country = $em->getRepository('WorldBundle:Country')->find($countryId);
		/** @var Nation $nation */
		$nation = $em->getRepository('WorldBundle:Nation')->find($nationId);

		$searchCriteria = [
			'country' => $countryId,
			'nation' => $nationId
		];
		/** @var NationsInCountries $nationsInCountries */
		$nationsInCountries = $em->getRepository('WorldBundle:NationsInCountries')->findOneBy($searchCriteria);

		if (is_null($nationsInCountries)) {
			$nationsInCountries = new NationsInCountries($country, $nation, $population);
			$em->persist($nationsInCountries);
			$em->flush();
		} else if ($nationsInCountries->getPopulation() != $population) {
			$nationsInCountries->setPopulation($population);
			$em->persist($nationsInCountries);
			$em->flush();
		}

		return $this->redirectToRoute('country_show', array('id' => $country->getId()));
	}
}
