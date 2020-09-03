<?php

namespace App\Services;

use App\Model\HasScheduleInterface;
use DateTime;

class OpeningHoursService
{

    /**
     * is store/charging station open
     * @param ScheduleInterface $obj    store / charging station
     * @param DateTime|null $date
     */
    public function isOpen(HasScheduleInterface $obj, ?DateTime $date): bool
    {
        $date = $date ?? new DateTime();    // if null, use the current date

        $timeItems = $this->getOpeningHoursForDay($obj, $date); // get string format of opening hours for day

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
     * get schedule by day
     *
     */
    private function getOpeningHoursForDay(HasScheduleInterface $obj, DateTime $date): ?array
    {
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
            default:
                $openingHours = null;
        }

        $timeItems = $this->getScheduleDay($openingHours); // get times for the current day
        return $timeItems;
    }

    /**
     * convert record to array of times from/to
     * @param ?string   $schedule       opening hours in text format
     */
    public function getScheduleDay(?string $schedule): array
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

    /**
     * get following change in the schedule
     */
    public function getNextChangeInSchedule(HasScheduleInterface $obj, ?DateTime $date): ?DateTime
    {
        $openingHours = $this->getOpeningHoursForDay($obj, $date); // get array of opening hours per day
        $currentTimestamp = intval($date->format("U")); // convert to int timestamp
        foreach($openingHours as $item) {
            // case when closing soon (but already open)
            if ($currentTimestamp >= strtotime($item['from'], $currentTimestamp) && $currentTimestamp < strtotime($item['to'], $currentTimestamp))
                return (new DateTime())->setTimestamp(strtotime($item['to'], $currentTimestamp)); // return "to" as datetime

            // case when not open yet
            if ($currentTimestamp < strtotime($item['from'], $currentTimestamp))
                return (new DateTime())->setTimestamp(strtotime($item['from'], $currentTimestamp)); // return "to" as datetime
        }

        // if not found, call method recursively with date + 1 day
        $nextDay = clone $date;
        $nextDay->modify("+1 day"); // modify day to following day
        $nextDay->format('Y-m-d');
        $nextDay = new \DateTime($date->format('Y-m-d')); // to remove time => set to 00:00
        return $this->getNextChangeInSchedule($obj, $nextDay);
    }

}