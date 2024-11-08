# PHP und das Dateisystem

Übungsprojekt zum Einlesen und Schreiben von Dateien. Nützlich,
wenn man beispielsweise Spielstände speichern oder laden möchte.

## Befehlsreferenz

- [Dateisystem](https://www.php.net/manual/en/ref.filesystem.php)
- [Ordner](https://www.php.net/manual/en/ref.dir.php)

## Stream, String oder Array

### Stream

Dateien können ähnlich wie Videos auf YouTube nicht komplett,
sondern als Stream geöffnet und stückchenweise verarbeitet werden.

``fopen()`` öffnet und ``fclose()`` schließt einen solchen Stream.
Während ein Stream geöffnet ist, kann eine Datei zeilenweise oder
bei **CSV**-Dateien auch spaltenweise gelesen werden. PHP überprüft
dabei die Datei auf Steuerzeichen für Zeilenumbrüche und ähnliches.

````php
<?php

function readAsStream(string $file): void
    {
        // Dateistream öffnen
        $handle = fopen($this->path.$file, "rb");
        if(!$handle) exit("Kann Datei nicht öffnen: ".$file);
        // Solange das Ende der Datei nicht erreicht ist:
        while(!feof($handle)) {
            // Zeile ausgeben
            echo fgets($handle);
        }
        // Stream schließen
        fclose($handle);
    }
````

``fopen()`` benötigt als zweiten Parameter entweder ``w`` für **Schreiben**
oder ``r`` für **Lesen**. Systeme, die zwischen Text- und Binärdateien unterscheiden,
benötigen zusätzlich den Wert ``b`` für *binär*.