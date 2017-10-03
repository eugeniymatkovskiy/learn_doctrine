<?php

namespace WorldBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WorldBundle\Entity\Continent;
use WorldBundle\Entity\Country;
use WorldBundle\Entity\Nation;
use WorldBundle\Entity\NationsInCountries;

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
	 * @Route("/control")
	 */
	public function controlAction() {
		return new Response('<html><body>Hello Admin</body></html>');
	}


	/**
	 * @Route("/getcountries/{id}", name="get_countries", requirements={"id": "\d+"})
	 */
	public function getCountriesAction(Continent $continent)
	{
		$countries = $continent->getCountries();

		$result = [];
		/** @var Country $country */
		foreach ($countries as $country) {
			$result[$country->getId()] = $country->getName();
		}

		$response = new JsonResponse();
		$response->setData($result);

		return $response;
	}

	/**
	 * @Route("/getnations/{id}")
	 */
	public function getNationsAction(Country $country) {

		$result = [];
		/** @var NationsInCountries $nationsInCountry */
		foreach ($country->getNationsInCountries() as $nationsInCountry) {
			/** @var Nation $nation */
			$nation = $nationsInCountry->getNation();

			$percent = round(($nationsInCountry->getPopulation() / $nation->getPopulation()) * 100, 2);

			$tmpData = [
				'name' => $nation->getTitle(),
				'totalPopulation' => $nation->getPopulation(),
				'populationInCountry' => $nationsInCountry->getPopulation(),
				'percent' => $percent
			];

			$result[] = $tmpData;
		}

		$response = new JsonResponse();
		$response->setData($result);

		return $response;
	}
}
