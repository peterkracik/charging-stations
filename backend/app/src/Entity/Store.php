<?php

namespace App\Entity;

use App\Model\ClientInterface;
use App\Model\HasScheduleExceptionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Model\HasScheduleInterface;
use App\Model\ScheduleExceptionInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 *
 */
class Store implements ClientInterface, HasScheduleInterface, HasScheduleExceptionInterface
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
     * @ORM\ManyToOne(targetEntity=Tenant::class, inversedBy="stores", cascade={"persist", "remove"})
     * @Serializer\Groups({"list", "detail"})
     */
    private $tenant;

    /**
     * @ORM\OneToMany(targetEntity=ChargingStation::class, mappedBy="store", cascade={"persist", "remove"})
     * @Serializer\Groups({"detail"})
     */
    private $chargingStations;

    /**
     * @ORM\ManyToOne(targetEntity=Schedule::class, cascade={"persist"})
     *
     */
    private $schedule;

    /**
     * @ORM\OneToMany(targetEntity=StoreScheduleException::class, mappedBy="store", cascade={"persist", "remove"})
     */
    private $scheduleExceptions;

    public function __construct()
    {
        $this->chargingStations = new ArrayCollection();
        $this->scheduleExceptions = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\Groups({"detail"})
     */
    public function getOpeningHours(): array
    {
        return [
            "monday"    => $this->getOpeningHoursForMonday() ?? false,
            "tuesday"   => $this->getOpeningHoursForTuesday() ?? false,
            "wednesday" => $this->getOpeningHoursForWednesday() ?? false,
            "thursday"  => $this->getOpeningHoursForThursday() ?? false,
            "friday"    => $this->getOpeningHoursForFriday() ?? false,
            "saturday"  => $this->getOpeningHoursForSaturday() ?? false,
            "sunday"    => $this->getOpeningHoursForSunday() ?? false,
        ];
    }

    public function getOpeningHoursForMonday()
    {
        return $this->getSchedule()->getOpeningHoursForMonday();
    }
    public function getOpeningHoursForTuesday()
    {
        return $this->getSchedule()->getOpeningHoursForTuesday();
    }
    public function getOpeningHoursForWednesday()
    {
        return $this->getSchedule()->getOpeningHoursForWednesday();
    }
    public function getOpeningHoursForThursday()
    {
        return $this->getSchedule()->getOpeningHoursForThursday();
    }
    public function getOpeningHoursForFriday()
    {
        return $this->getSchedule()->getOpeningHoursForFriday();
    }
    public function getOpeningHoursForSaturday()
    {
        return $this->getSchedule()->getOpeningHoursForSaturday();
    }
    public function getOpeningHoursForSunday()
    {
        return $this->getSchedule()->getOpeningHoursForSunday();
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

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    /**
     * @return Collection|ChargingStation[]
     */
    public function getChargingStations(): Collection
    {
        return $this->chargingStations;
    }

    public function addChargingStation(ChargingStation $chargingStation): self
    {
        if (!$this->chargingStations->contains($chargingStation)) {
            $this->chargingStations[] = $chargingStation;
            $chargingStation->setStore($this);
        }

        return $this;
    }

    public function removeChargingStation(ChargingStation $chargingStation): self
    {
        if ($this->chargingStations->contains($chargingStation)) {
            $this->chargingStations->removeElement($chargingStation);
            // set the owning side to null (unless already changed)
            if ($chargingStation->getStore() === $this) {
                $chargingStation->setStore(null);
            }
        }

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

    /**
     * @return Collection|StoreScheduleException[]
     */
    public function getScheduleExceptions(): Collection
    {
        return $this->scheduleExceptions;
    }

    public function addScheduleException(ScheduleExceptionInterface $scheduleException): self
    {
        if (!$this->scheduleExceptions->contains($scheduleException)) {
            $this->scheduleExceptions[] = $scheduleException;
            $scheduleException->setClient($this);
        }

        return $this;
    }

    public function removeScheduleException(ScheduleExceptionInterface $scheduleException): self
    {
        if ($this->scheduleExceptions->contains($scheduleException)) {
            $this->scheduleExceptions->removeElement($scheduleException);
            // set the owning side to null (unless already changed)
            if ($scheduleException->getClient() === $this) {
                $scheduleException->setClient(null);
            }
        }

        return $this;
    }
}
