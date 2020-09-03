<?php


namespace App\Model;

interface ClientInterface
{
    public function getId(): ?int;

    public function setName(string $name): ?self;

    public function getName(): ?string;
}
