<?php

namespace App;

class Game
{

    private string $charName = "Bernd";
    private int $hp = 500;

    private int $speed = 100;

    public function getCharName(): string
    {
        return $this->charName;
    }

    public function setCharName(string $charName): void
    {
        $this->charName = $charName;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function setHp(int $hp): void
    {
        $this->hp = $hp;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): void
    {
        $this->speed = $speed;
    }

    public function __serialize(): array
    {
        return [
          $this->charName,
          $this->hp,
          $this->speed,
        ];
    }

    public function __unserialize(array $data): void
    {
        list(
            $this->charName,
            $this->hp,
            $this->speed
            ) = $data;
    }


}