<?php

function gcd($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

function kgV($a, $b): float|int
{
    return ($a * $b) / gcd($a, $b);
}

function addiereVektoren($v1, $v2): array
{
    // Extrahiere die Komponenten der Vektoren
    list($a1, $b1) = $v1;
    list($a2, $b2) = $v2;

    if($v1[1] != 0) $r1 = $v1[2] ?? $v1[0] % $v1[1];
    else $r1 = 0;
    if($v2[1] != 0) $r2 = $v2[2] ?? $v2[0] % $v2[1];
    else $r2 = 0;

    // Gemeinsamer Divisor (kgV)
    $b_neu = kgV($b1, $b2);

    // Angepasste Dividenden und Reste
    if($b1 != 0) {
        $a1_neu = $a1 * ($b_neu / $b1);
        $r1_neu = $r1 * ($b_neu / $b1);
    } else {
        $a1_neu = $a1 * $b_neu;
        $r1_neu = $r1 * $b_neu;
    }

    if($b2 != 0) {
        $a2_neu = $a2 * ($b_neu / $b2);
        $r2_neu = $r2 * ($b_neu / $b2);
    } else {
        $a2_neu = $a2 * $b_neu;
        $r2_neu = $r2 * $b_neu;
    }

    // Addiere Dividenden und Reste
    $a_neu = $a1_neu + $a2_neu;
    if ($r2_neu != 0) {
        $r_neu = $r1_neu / $r2_neu;
    } else {
        $r_neu = $r1_neu;
    }


    // Normiere den Rest
    if ($r_neu >= $b_neu and $b_neu != 0) {
        $a_neu += intdiv($r_neu,  $b_neu);
    } elseif ($r_neu >= $b_neu) {
        $a_neu += $r1_neu;
    }

    if($b_neu != 0)
        return [$a_neu, $b_neu, $a_neu % $b_neu];
    else
        return [$a_neu, $b_neu, 0];
}

function subtractVectors($v1, $v2): array
{
    // Extrahiere die Komponenten der Vektoren
    list($a1, $b1) = $v1;
    list($a2, $b2) = $v2;

    if($v1[1] != 0) $r1 = $v1[2] ?? $v1[0] % $v1[1];
    else $r1 = 0;
    if($v2[1] != 0) $r2 = $v2[2] ?? $v2[0] % $v2[1];
    else $r2 = 0;

    // Berechne das kgV der Divisoren
    $b_neu = kgV($b1, $b2);

    // Passe die Dividenden und Reste an den neuen Divisor an
    $a1_neu = $a1 * ($b_neu / $b1);
    $r1_neu = $r1 * ($b_neu / $b1);

    $a2_neu = $a2 * ($b_neu / $b2);
    $r2_neu = $r2 * ($b_neu / $b2);

    // Subtrahiere Dividenden und Reste
    $a_neu = $a1_neu - $a2_neu;
    $r_neu = $r1_neu - $r2_neu;

    // Normiere den Rest
    if ($r_neu < 0) {
        $a_neu -= intdiv(abs($r_neu), $b_neu);
        $r_neu = ($r_neu % $b_neu + $b_neu) % $b_neu;
    }

    return [$a_neu, $b_neu, $r_neu];
}

function length(array $v): string
{
    list($a, $b) = $v;
    $r = $v[2] ?? $a % $b;

    if($b != 0) {
        if($a % $b == 0 and $r != 0) {
            $result = $a / $b + $r / $b;
        } else {
            $result =  floor($a/$b) . " + $r/$b = ".floor($a/$b)+$r/$b;
        }
    } else {
        $result = $a;
    }

    return $result;
}

function length3D(array $v): float
{
    return pow(length($v), 2);
}

// Beispiel-Vektoren
$v1 = [7, 5]; // Vektor 1: (a = 10, b = 4, r = unbekannt)
$v2 = [0, 0]; // Vektor 2: (a = 15, b = 6, r = unbekannt)

// Vektoraddition
$ergebnis1 = addiereVektoren($v1, $v2);
$ergebnis2 = [1,1,1]; //subtractVectors($v1, $v2);

echo "\nAddition und Subtraktion schriftlich dividierter\nTerme als Vektorkomponenten-Darstellung:\n";

echo <<<TXT

Ein Vektor a = (a,b,r) hat die Komponenten:

a = Dividend
b = Divisor
r = Rest (falls bekannt)

dann ist a1/b1 = (a1, b1, r)

Die Addition und Subtraktion schriftlich dividierter Terme
wird folgendermaßen notiert:


TXT;


echo "Beispiel 1:\n$v1[0]/$v1[1] + $v2[0]/$v2[1]: \n(Die Länge des Vektors ist a/b)\n";
echo "($v1[0],$v1[1]) + ($v2[0],$v2[1]) = ";
echo "(" . $ergebnis1[0] . ", " . $ergebnis1[1] . ", " . $ergebnis1[2] . ") = ". length($ergebnis1) . "\n\n";

echo "Beispiel 2:\n$v1[0]/$v1[1] - $v2[0]/$v2[1]: \n";
echo "($v1[0],$v1[1]) - ($v2[0],$v2[1]) = ";
echo "(" . $ergebnis2[0] . ", " . $ergebnis2[1] . ", " . $ergebnis2[2] . ") = ". length($ergebnis2) . "\n";


