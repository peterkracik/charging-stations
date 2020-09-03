<?php

namespace App\Services;

use App\Entity\ScheduleException;
use App\Model\HasScheduleExceptionInterface;
use App\Model\ScheduleInterface;
use DateTime;

class ScheduleExceptionService
{

    /**
     * get exception for the object
     * @param ScheduleInterface $obj    store / charging station
     * @param DateTime|null $date
     */
    public static function getExceptionByDate(HasScheduleExceptionInterface $obj, ?DateTime $date): ?ScheduleException
    {
        $date = $date ?? new DateTime();    // if null, use the current date

        return null;
    }

}