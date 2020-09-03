<?php

namespace App\Services;

use App\Entity\ChargingStation;
use DateTime;

class ChargingStationService
{

    /**
     * @var OpeningHoursService
     */
    private $openingHoursService;

    public function __construct(
        OpeningHoursService $openingHoursService
    ) {
        $this->openingHoursService = $openingHoursService;
    }

    /**
     * return availability of the station for the current date/time
     *
     */
    public function isOpen(ChargingStation $station, DateTime $date): bool
    {
        return $this->openingHoursService->isOpen($station, $date);
    }

}