<?php

namespace WorldBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use WorldBundle\Entity\Continent;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
	    $em = $this->getDoctrine()->getManager();
	    $continents = $em->getRepository('WorldBundle:Continent')->findAll();

	    $templateArgs = ['continents' => $continents, 'name' => 'google'];
        return $this->render('WorldBundle:Default:index.html.twig', $templateArgs);
	}

	/**
	 * @Route("/getcountries/{id}", name="get_countries")
	 */
    public function getCountriesAction(Continent $continent) {
    	$countries = $continent->getCountries();

        $result = [];
	    foreach ($countries as $country) {

	    }

    	$response = new JsonResponse();
    	$response->setData();

		return $response;
    }
}
