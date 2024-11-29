<?php

namespace App\Entity;

class Lehrkraft
{

    private int $persId;
    private string $name;
    private string $wohnort;

    public function getPersId(): int
    {
        return $this->persId;
    }

    public function setPersId(int $persId): void
    {
        $this->persId = $persId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getWohnort(): string
    {
        return $this->wohnort;
    }

    public function setWohnort(string $wohnort): void
    {
        $this->wohnort = $wohnort;
    }

}