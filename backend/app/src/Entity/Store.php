<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Tenant::class, inversedBy="stores")
     */
    private $tenant;

    /**
     * @ORM\OneToMany(targetEntity=ChargingStation::class, mappedBy="store")
     */
    private $chargingStations;

    public function __construct()
    {
        $this->chargingStations = new ArrayCollection();
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
}
