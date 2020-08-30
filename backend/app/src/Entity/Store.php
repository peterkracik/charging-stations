<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 * @ApiResource(
 *  itemOperations={
 *         "get"
 *  },
 *  normalizationContext={"groups"={"store"}})
 * )
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"charging_station", "store", "tenant"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"charging_station", "store", "tenant"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Tenant::class, inversedBy="stores")
     * @Groups({"charging_station", "store"})
     */
    private $tenant;

    /**
     * @ORM\OneToMany(targetEntity=ChargingStation::class, mappedBy="store")
     * @Groups({"store"})
     */
    private $chargingStations;

    /**
     * @ORM\ManyToOne(targetEntity=Schedule::class, cascade={"persist"})
     */
    private $schedule;

    public function __construct()
    {
        $this->chargingStations = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
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
}
