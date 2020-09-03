<?php

namespace App\Entity;

use App\Model\ClientInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoreScheduleExceptionRepository")
 *
 */
class StoreScheduleException extends ScheduleException
{

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="scheduleExceptions", cascade={"persist", "remove"})
     */
    public $client;

}
