<?php

namespace App\Entity;

use DateTime;

/**
 */
class Timespan
{
    /**
     * @var DateTime
     */
    private $from;

    /**
     * @var Datetime
     */
    private $to;

    /**
     * @var Boolean
     */
    private $open;

    /**
     * @var int
     */
    private $priority = 1;

    public function __construct(DateTime $from, DateTime $to, bool $open = true, int $priority = 1)
    {
        $this->setFrom($from);
        $this->setTo($to);
        $this->setOpen($open);
        $this->setPriority($priority);
    }

    public function getFrom(): DateTime
    {
        return $this->from;
    }

    public function setFrom(DateTime $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function getTo(): DateTime
    {
        return $this->to;
    }

    public function setTo(DateTime $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): self
    {
        $this->open = $open;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }
}
