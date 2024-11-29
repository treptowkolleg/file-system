<?php


class Vector
{
    private int $x,$y,$z;

    public function __construct(int $x = 0, int $y = 0, int $z = 0)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function __toString(): string
    {
        return "({$this->x}|{$this->y}|{$this->z})";
    }

    public function hasLinDependency(Vector $v): bool
    {
        return !array_product($this->cross($v)->getArray());
    }

    public function cross(Vector $v):Vector
    {
        $x = $this->y*$v->getZ() - $this->z * $v->getY();
        $y = $this->z*$v->getX() - $this->x * $v->getZ();
        $z = $this->x*$v->getY() - $this->y * $v->getX();
        return new Vector($x,$y,$z);
    }

    public function add(Vector $v):Vector
    {
        $this->x += $v->getX();
        $this->y += $v->getY();
        $this->z += $v->getZ();
        return $this;
    }

    public function subtract(Vector $v):Vector
    {
        $this->x -= $v->getX();
        $this->y -= $v->getY();
        $this->z -= $v->getZ();
        return $this;
    }

    public function multiplyBy(float $scalar):Vector
    {
        $this->x *= $scalar;
        $this->y *= $scalar;
        $this->z *= $scalar;
        return $this;
    }

    public function getArray(): array
    {
        return [$this->x, $this->y, $this->z];
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getZ(): int
    {
        return $this->z;
    }

}

$a = new Vector(1,1,3);
$b = new Vector(2,1,3);

if($a->hasLinDependency($b)) {
    echo "Die Vektoren $a und $b sind linear abhängig\n";
} else {
    echo "Die Vektoren $a und $b sind NICHT linear abhängig\n";
}

echo "$a\t+\t\t$b\t=\t{$a->add($b)}\n";
echo "$a\t+\t4x\t$b\t=\t{$a->add($b->multiplyBy(4))}\n";