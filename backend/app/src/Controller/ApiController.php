<?php

namespace App\Controller;

use App\Entity\ChargingStation;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    private $em;

    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $this->em = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/stations", name="charging_stations", methods={"GET"})
     */
    public function getStations()
    {
        $stations = $this->getDoctrine()
            ->getRepository(ChargingStation::class)
            ->findAll();

        $json = $this->serializer->serialize(
            $stations,
            'json',
            SerializationContext::create()->setGroups(['list'])
        );
        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/stations/{id}", name="charging_station", methods={"GET"})
     */
    public function getStation(ChargingStation $station)
    {

        $json = $this->serializer->serialize(
            $station,
            'json',
            SerializationContext::create()->setGroups(['detail'])
        );
        return new JsonResponse($json, 200, [], true);
    }
}
