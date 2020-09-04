<?php

namespace App\Services;

use App\Entity\Timespan;
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

        // foreach time in records compare if the current time is uncluded
        foreach($timeItems as $item) {

            // compare with the time fork
            if ($date >= $item->getFrom() && $date <= $item->getTo())
                return true;

        }

        return false;
    }

    /**
     * get schedule by day
     *
     */
    public function getOpeningHoursForDay(HasScheduleInterface $obj, DateTime $date): ?array
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

        return $this->getScheduleDay($openingHours, $date); // get times for the current day
    }

    /**
     * convert record to array of times from/to
     * @param ?string   $schedule       opening hours in text format
     */
    public function getScheduleDay(?string $schedule, DateTime $date): array
    {
        // if empty, store/station is closed
        if (!$schedule) return false;

        $currentTimestamp = intval($date->format("U")); // convert to int timestamp

        $times = explode(";", $schedule);

        // get array of timespans for the current day
        $times = array_map(function($item) use($currentTimestamp) {
            $item_elem = explode("-", $item);
            $timeSpan = new Timespan(
                (new DateTime())->setTimestamp(strtotime($item_elem[0], $currentTimestamp)),
                (new DateTime())->setTimestamp(strtotime($item_elem[1], $currentTimestamp)),
            );
            return $timeSpan;
        }, $times);
        return $times;
    }


    /**
     * get following change in the schedule
     */
    public function getNextChangeInSchedule(HasScheduleInterface $obj, bool $currentlyOpen, ?DateTime $date): ?DateTime
    {
        $openingHours = $this->getOpeningHoursForDay($obj, $date); // get array of opening hours per day
        foreach($openingHours as $item) {
            // if it's open, search for next TO time
            if ($currentlyOpen === true && $date < $item->getTo()) {
                return $item->getTo(); // return "to" as datetime
            }
            if ($currentlyOpen === false && $date < $item->getFrom()) {
                return $item->getFrom(); // return "to" as datetime
            }
        }

        // if not found, call method recursively for the next day
        $nextDay = clone $date;
        $nextDay->modify("+1 day"); // modify day to following day
        $nextDay->format('Y-m-d');
        $nextDay = new \DateTime($nextDay->format('Y-m-d')); // to remove time => set to 00:00
        return $this->getNextChangeInSchedule($obj, $currentlyOpen, $nextDay);
    }

    /**
     * returns current opening hour schedule, or "close" schedule until next
     */
    public function getCurrentSchedule(HasScheduleInterface $obj, ?DateTime $date): Timespan
    {
        $openingHours = $this->getOpeningHoursForDay($obj, $date); // get array of opening hours per day
        foreach ($openingHours as $item) {
            // if it's open, search for next TO time
            if ($date < $item->getFrom() && $date < $item->getTo()) {
                return $item; // return "to" as datetime
            }
        }

        $next = $this->getNextSchedule($obj, $date);
        // returns "close" schedule until next opening
        return new Timespan($date, $next->getFrom(), false, 1);
    }

    public function getNextSchedule(HasScheduleInterface $obj, ?DateTime $date): ?Timespan
    {
        $openingHours = $this->getOpeningHoursForDay($obj, $date); // get array of opening hours per day
        foreach ($openingHours as $item) {
            // if it's open, search for next TO time
            if ($date > $item->getFrom()) {
                return $item; // return "to" as datetime
            }
        }
    }
}