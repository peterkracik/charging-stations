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
    public $client;

    protected $priority = 2;
}
