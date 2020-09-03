<?php

namespace App\Entity;

use App\Model\ClientInterface;
use App\Model\ScheduleExceptionInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "station"   = "StationScheduleException",
 *      "store"     = "StoreScheduleException",
 *      "tenant"    = "TenantScheduleException",
 * })
 */
abstract class ScheduleException implements ScheduleExceptionInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="boolean")
     */
    private $open;

    /**
     * @var CLientInterface
     */
    public $client;

    public function __toString()
    {
        return $this->getStart()->format('Y-m-d H:m') . " - " . $this->getEnd()->format('Y-m-d H:m') ?? '';
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function isOpen(): ?bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): self
    {
        $this->open = $open;

        return $this;
    }

    public function getClient(): ?ClientInterface
    {
        return $this->client;
    }

    public function setClient(?ClientInterface $client): self
    {
        $this->client = $client;
        return $this;
    }
}
