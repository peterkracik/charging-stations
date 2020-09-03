<?php

namespace App\Entity;

use App\Model\ClientInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TenantScheduleExceptionRepository")
 *
 */
class TenantScheduleException extends ScheduleException
{

    /**
     * @ORM\ManyToOne(targetEntity=tenant::class, inversedBy="scheduleExceptions", cascade={"persist", "remove"})
     */
    public $client;
}
