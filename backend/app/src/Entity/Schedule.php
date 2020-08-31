<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScheduleRepository::class)
 */
class Schedule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $monday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tuesday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wednesday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thursday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $friday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $saturday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sunday;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openMonday = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openTuesday = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openWednesday = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openThursday = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openFriday = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openSaturday = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $openSunday = true;


    public function getOpeningHoursForMonday()
    {
        return (!$this->isOpenMonday()) ? $this->isOpenMonday() : $this->getMonday();
    }
    public function getOpeningHoursForTuesday()
    {
        return (!$this->isOpenTuesday()) ? $this->isOpenTuesday() : $this->getTuesday();
    }
    public function getOpeningHoursForWednesday()
    {
        return (!$this->isOpenWednesday()) ? $this->isOpenWednesday() : $this->getWednesday();
    }
    public function getOpeningHoursForThursday()
    {
        return (!$this->isOpenThursday()) ? $this->isOpenThursday() : $this->getThursday();
    }
    public function getOpeningHoursForFriday()
    {
        return (!$this->isOpenFriday()) ? $this->isOpenFriday() : $this->getFriday();
    }
    public function getOpeningHoursForSaturday()
    {
        return (!$this->isOpenSaturday()) ? $this->isOpenSaturday() : $this->getSaturday();
    }
    public function getOpeningHoursForSunday()
    {
        return (!$this->isOpenSunday()) ? $this->isOpenSunday() : $this->getSunday();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonday(): ?string
    {
        return $this->monday;
    }

    public function setMonday(?string $monday): self
    {
        $this->monday = $monday;

        return $this;
    }

    public function getTuesday(): ?string
    {
        return $this->tuesday;
    }

    public function setTuesday(?string $tuesday): self
    {
        $this->tuesday = $tuesday;

        return $this;
    }

    public function getWednesday(): ?string
    {
        return $this->wednesday;
    }

    public function setWednesday(?string $wednesday): self
    {
        $this->wednesday = $wednesday;

        return $this;
    }

    public function getThursday(): ?string
    {
        return $this->thursday;
    }

    public function setThursday(?string $thursday): self
    {
        $this->thursday = $thursday;

        return $this;
    }

    public function getFriday(): ?string
    {
        return $this->friday;
    }

    public function setFriday(?string $friday): self
    {
        $this->friday = $friday;

        return $this;
    }

    public function getSaturday(): ?string
    {
        return $this->saturday;
    }

    public function setSaturday(?string $saturday): self
    {
        $this->saturday = $saturday;

        return $this;
    }

    public function getSunday(): ?string
    {
        return $this->sunday;
    }

    public function setSunday(?string $sunday): self
    {
        $this->sunday = $sunday;

        return $this;
    }

    public function isOpenMonday(): ?bool
    {
        return $this->openMonday;
    }

    public function setOpenMonday(bool $openMonday): self
    {
        $this->openMonday = $openMonday;

        return $this;
    }

    public function isOpenTuesday(): ?bool
    {
        return $this->openTuesday;
    }

    public function setOpenTuesday(bool $openTuesday): self
    {
        $this->openTuesday = $openTuesday;

        return $this;
    }

    public function isOpenWednesday(): ?bool
    {
        return $this->openWednesday;
    }

    public function setOpenWednesday(bool $openWednesday): self
    {
        $this->openWednesday = $openWednesday;

        return $this;
    }

    public function isOpenThursday(): ?bool
    {
        return $this->openThursday;
    }

    public function setOpenThursday(bool $openThursday): self
    {
        $this->openThursday = $openThursday;

        return $this;
    }

    public function isOpenFriday(): ?bool
    {
        return $this->openFriday;
    }

    public function setOpenFriday(bool $openFriday): self
    {
        $this->openFriday = $openFriday;

        return $this;
    }

    public function isOpenSaturday(): ?bool
    {
        return $this->openSaturday;
    }

    public function setOpenSaturday(bool $openSaturday): self
    {
        $this->openSaturday = $openSaturday;

        return $this;
    }

    public function isOpenSunday(): ?bool
    {
        return $this->openSunday;
    }

    public function setOpenSunday(bool $openSunday): self
    {
        $this->openSunday = $openSunday;

        return $this;
    }
}
