<?php


namespace App\Model;

interface ScheduleInterface
{
    public function isOpen(): bool;

    public function getOpeningHours(): array;

    public function getOpeningHoursForMonday();

    public function getOpeningHoursForTuesday();

    public function getOpeningHoursForWednesday();

    public function getOpeningHoursForThursday();

    public function getOpeningHoursForFriday();

    public function getOpeningHoursForSaturday();

    public function getOpeningHoursForSunday();
}
