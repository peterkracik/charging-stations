<?php

namespace App\Controller;

use App\Entity\ChargingStation;
use App\Services\ChargingStationService;
use DateTime;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $serializer;

    /**
     * @var ChargingStationService
     */
    private $chargingStationService;

    public function __construct(
        SerializerInterface $serializer,
        ChargingStationService $chargingStationService
    ) {
        $this->serializer = $serializer;
        $this->chargingStationService = $chargingStationService;
    }

    /**
     * @Route("/stations", name="charging_station_list", methods={"GET"})
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
     * Get station by id
     * @Route("/stations/{id}", name="charging_station_detail", methods={"GET"})
     */
    public function getStation(ChargingStation $station = null)
    {
        if (!$station) return new JsonResponse("{}", 404, [], true);

        $json = $this->serializer->serialize(
            $station,
            'json',
            SerializationContext::create()->setGroups(['detail'])
        );

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/stations/{id}/open", name="charging_station_open", methods={"GET"})
     */
    public function getStationStatus(Request $request, ChargingStation $station = null)
    {
        if (!$station) return new JsonResponse("{}", 404, [], true);

        $body = json_decode($request->getContent(), true); // get body of the api request
        $date = new DateTime($body['date'] ?? null);       // create date object
        $isOpen = $this->chargingStationService->isOpen($station, $date);      // verify if station is open

        $data = [
            "open" => $isOpen
        ];

        $json = $this->serializer->serialize(
            $data,
            'json',
        );

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/stations/{id}/status_change", name="charging_station_status_change", methods={"GET"})
     */
    public function getStationNextStatusChange(Request $request, ChargingStation $station = null)
    {
        if (!$station) return new JsonResponse("{}", 404, [], true);

        $body = json_decode($request->getContent(), true); // get body of the api request
        $date = new DateTime($body['date'] ?? null);       // create date object
        $changeDate = $this->chargingStationService->searchStatusChange($station, $date);      // verify if station is open

        $data = [
            "date" => $changeDate->format('c'),
        ];

        $json = $this->serializer->serialize(
            $data,
            'json',
        );

        return new JsonResponse($json, 200, [], true);
    }
}
