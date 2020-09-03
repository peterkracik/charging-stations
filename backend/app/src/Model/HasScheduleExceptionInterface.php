<?php


namespace App\Model;

use App\Entity\ScheduleException;
use DateTime;
use Doctrine\Common\Collections\Collection;

interface HasScheduleExceptionInterface
{

    public function getScheduleExceptions(): Collection;

    public function addScheduleException(ScheduleExceptionInterface $scheduleException): self;

    public function removeScheduleException(ScheduleExceptionInterface $scheduleException): self;

}
