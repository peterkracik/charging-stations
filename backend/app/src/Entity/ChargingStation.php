<?php

namespace App\Entity;

use App\Repository\ChargingStationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChargingStationRepository::class)
 * @ApiResource(
 *  itemOperations={
 *         "get"
 *  },
 * normalizationContext={"groups"={"charging_station"}})
 * )
 */
class ChargingStation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"charging_station", "store"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"charging_station", "store"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="chargingStations")
     * @ApiSubresource
     * @Groups({"charging_station"})
     */
    private $store;


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

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
}
