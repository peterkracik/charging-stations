<?php

namespace App\Entity;

use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TenantRepository::class)
 * @ApiResource(
 *  itemOperations={
 *         "get"
 *  },
 *  normalizationContext={"groups"={"tenant"}})
 * )
 */
class Tenant
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
     * @ORM\OneToMany(targetEntity=Store::class, mappedBy="tenant")
     * @Groups({"tenant"})
     */
    private $stores;

    public function __construct()
    {
        $this->stores = new ArrayCollection();
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

    /**
     * @return Collection|Store[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
            $store->setTenant($this);
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        if ($this->stores->contains($store)) {
            $this->stores->removeElement($store);
            // set the owning side to null (unless already changed)
            if ($store->getTenant() === $this) {
                $store->setTenant(null);
            }
        }

        return $this;
    }
}
