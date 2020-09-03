<?php

namespace App\Entity;

use App\Model\ClientInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 */
class TenantScheduleException extends ScheduleException
{

    /**
     * @ORM\ManyToOne(targetEntity=Tenant::class, inversedBy="scheduleExceptions", cascade={"persist", "remove"})
     */
    private $tenant;

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getClient(): ?ClientInterface
    {
        return $this->getTenant();
    }

    public function setClient(?ClientInterface $tenant): self
    {
        return $this->setTenant($tenant);
    }
}
