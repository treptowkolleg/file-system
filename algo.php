<?php

echo "Lösungsmenge zur Ermittelung der Tage für 10 Umläufe,
wann sich beiden Monde gegenseitig beschatten:" . PHP_EOL . PHP_EOL;

for ($k = 0; $k < 10; $k++) {
    $d = 5 - 5/6 + 10 * $k;
    echo "bei $d Tagen" . PHP_EOL;
}

