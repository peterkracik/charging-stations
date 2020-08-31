<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\ScheduleInterface;
use App\Services\OpeningHoursService;
use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 */
class ChargingStation implements ScheduleInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list", "detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list", "detail"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="chargingStations")
     * @Serializer\Groups({"list", "detail"})
     */
    private $store;

    /**
     * @ORM\ManyToOne(targetEntity=Schedule::class, cascade={"persist"})
     *
     */
    private $schedule;

    public function __toString(): string
    {
        return $this->getName();
    }


    /**
     * @Serializer\VirtualProperty()
     * @Serializer\Groups({"list", "detail"})
     */
    public function isOpen(?DateTime $date = null): bool
    {
        $isOpen = OpeningHoursService::isOpen($this, $date);
        return $isOpen;
    }


    /**
     * @Serializer\VirtualProperty()
     * @Serializer\Groups({"detail"})
     */
    public function getOpeningHours(): array
    {
        return [
            "monday"    => $this->getOpeningHoursForMonday(),
            "tuesday"   => $this->getOpeningHoursForTuesday(),
            "wednesday" => $this->getOpeningHoursForWednesday(),
            "thursday"  => $this->getOpeningHoursForThursday(),
            "friday"    => $this->getOpeningHoursForFriday(),
            "saturday"  => $this->getOpeningHoursForSaturday(),
            "sunday"    => $this->getOpeningHoursForSunday(),
        ];
    }

    public function getOpeningHoursForMonday()
    {
        return $this->getSchedule()->getOpeningHoursForMonday() ?? $this->store->getSchedule()->getOpeningHoursForMonday();
    }
    public function getOpeningHoursForTuesday()
    {
        return $this->getSchedule()->getOpeningHoursForTuesday() ?? $this->store->getSchedule()->getOpeningHoursForTuesday();
    }
    public function getOpeningHoursForWednesday()
    {
        return $this->getSchedule()->getOpeningHoursForWednesday() ?? $this->store->getSchedule()->getOpeningHoursForWednesday();
    }
    public function getOpeningHoursForThursday()
    {
        return $this->getSchedule()->getOpeningHoursForThursday() ?? $this->store->getSchedule()->getOpeningHoursForThursday();
    }
    public function getOpeningHoursForFriday()
    {
        return $this->getSchedule()->getOpeningHoursForFriday() ?? $this->store->getSchedule()->getOpeningHoursForFriday();
    }
    public function getOpeningHoursForSaturday()
    {
        return $this->getSchedule()->getOpeningHoursForSaturday() ?? $this->store->getSchedule()->getOpeningHoursForSaturday();
    }
    public function getOpeningHoursForSunday()
    {
        return $this->getSchedule()->getOpeningHoursForSunday() ?? $this->store->getSchedule()->getOpeningHoursForSunday();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }
}
