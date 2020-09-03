<?php


namespace App\Model;

interface ScheduleExceptionInterface
{

    public function getId(): ?int;

    public function getStart(): ?\DateTimeInterface;

    public function setStart(\DateTimeInterface $start): self;

    public function getEnd(): ?\DateTimeInterface;

    public function setEnd(\DateTimeInterface $end): self;

    public function isOpen(): ?bool;

    public function setOpen(bool $open): self;

    /**
     * get related objects
     */
    public function getClient(): ?ClientInterface;

    /**
     * set related objects
     */
    public function setClient(?ClientInterface $client): self;
}
