<?php

namespace App\Entity;

use App\Model\ClientInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 */
class StoreScheduleException extends ScheduleException
{

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="scheduleExceptions", cascade={"persist", "remove"})
     */
    private $store;

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getClient(): ?ClientInterface
    {
        return $this->getStore();
    }

    public function setClient(?ClientInterface $store): self
    {
        return $this->setStore($store);
    }
}
