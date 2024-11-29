<?php

namespace App\Entity;



use DateTime;
use DateTimeImmutable;

class Lehrkraft
{

    private int $persnr;
    private string $name;
    private string $geschlecht;
    private string $wohnort;
    private int $geburtsjahr;

    public function getPersnr(): int
    {
        return $this->persnr;
    }

    public function setPersnr(int $persnr): void
    {
        $this->persnr = $persnr;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getGeschlecht(): string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(string $geschlecht): void
    {
        $this->geschlecht = $geschlecht;
    }

    public function getWohnort(): string
    {
        return $this->wohnort;
    }

    public function setWohnort(string $wohnort): void
    {
        $this->wohnort = $wohnort;
    }

    public function getGeburtsjahr(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y', $this->geburtsjahr);
    }

    public function setGeburtsjahr(int $geburtsjahr): void
    {
        $this->geburtsjahr = $geburtsjahr;
    }


}