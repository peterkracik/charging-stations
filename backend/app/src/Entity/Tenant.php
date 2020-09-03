<?php

namespace App\Entity;

use App\Model\ClientInterface;
use App\Model\HasScheduleExceptionInterface;
use App\Model\ScheduleExceptionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Tenant implements ClientInterface, HasScheduleExceptionInterface
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
     * @ORM\OneToMany(targetEntity=Store::class, mappedBy="tenant", cascade={"persist", "remove"})
     */
    private $stores;

    /**
     * @ORM\OneToMany(targetEntity=TenantScheduleException::class, mappedBy="tenant", cascade={"persist", "remove"})
     */
    private $scheduleExceptions;

    public function __construct()
    {
        $this->stores = new ArrayCollection();
        $this->scheduleExceptions = new ArrayCollection();
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

    /**
     * @return Collection|TenantScheduleException[]
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
