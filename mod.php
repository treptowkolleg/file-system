<?php


// Teilbarkeit ermitteln. Der Rest wird zurückgegeben (0 bis $b-1)
function modulo(int $dividend, int $divisor): int
{
    $k = 0;
    while ($k <= 0) {
        $dividend -= $divisor;
        $k = $divisor - $dividend;
    }
    return $dividend;
}
$seconds = (int) date("s");

echo modulo(5,2);