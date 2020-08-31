<?php

namespace App\Services;

use App\Model\ScheduleInterface;
use DateTime;

class OpeningHoursService
{

    /**
     * is store/charging station open
     * @param ScheduleInterface $obj    store / charging station
     * @param DateTime|null $date
     */
    public static function isOpen(ScheduleInterface $obj, ?DateTime $date)
    {
        $date = $date ?? new DateTime();    // if null, use the current date
        $day = $date->format('w');          // get the day from date object

        switch ($day) {
            case 0:
                $openingHours = $obj->getOpeningHoursForSunday();
                break;
            case 1:
                $openingHours = $obj->getOpeningHoursForMonday();
                break;
            case 2:
                $openingHours = $obj->getOpeningHoursForTuesday();
                break;
            case 3:
                $openingHours = $obj->getOpeningHoursForWednesday();
                break;
            case 4:
                $openingHours = $obj->getOpeningHoursForThursday();
                break;
            case 5:
                $openingHours = $obj->getOpeningHoursForFriday();
                break;
            case 6:
                $openingHours = $obj->getOpeningHoursForSaturday();
                break;
        }

        // var_dump($openingHours);
        $timeItems = self::getScheduleDay($openingHours); // get times for the current day

        if (!$timeItems) return false;  // return false if it closed
        $currentTimestamp = intval($date->format("U")); // convert to int timestamp

        // foreach time in records compare if the current time is uncluded
        foreach($timeItems as $item) {

            // compare with the time fork
            if ($currentTimestamp >= strtotime($item['from'], $currentTimestamp) && $currentTimestamp <= strtotime($item['to'], $currentTimestamp)) {
                return true;
            }
        }

        return false;
    }

    /**
     * convert record to array of times from/to
     * @param ?string   $schedule       opening hours in text format
     */
    public static function getScheduleDay(?string $schedule)
    {
        // if empty, store/station is closed
        if (!$schedule) return false;

        $times = explode(";", $schedule);
        $times = array_map(function($item) {
            $item_elem = explode("-", $item);
            return [
                "from" => $item_elem[0],
                "to" =>  $item_elem[1],
            ];
        }, $times);
        return $times;
    }

}