<?php

namespace App\Entity;

use App\Model\ClientInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StationScheduleExceptionRepository")
 *
 */
class StationScheduleException extends ScheduleException
{

    /**
     * @ORM\ManyToOne(targetEntity=ChargingStation::class, inversedBy="scheduleExceptions", cascade={"persist", "remove"})
     */
    private $station;


    public function getStation(): ?ChargingStation
    {
        return $this->station;
    }

    public function setStation(?ChargingStation $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getClient(): ?ClientInterface
    {
        return $this->getStation();
    }

    public function setClient(?ClientInterface $store): self
    {
        return $this->setStation($store);
    }

}
