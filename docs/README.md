# PHP und das Dateisystem

Übungsprojekt zum Einlesen und Schreiben von Dateien. Nützlich,
wenn man beispielsweise Spielstände speichern oder laden möchte.

<!-- TOC -->
* [PHP und das Dateisystem](#php-und-das-dateisystem)
  * [Befehlsreferenz](#befehlsreferenz)
  * [Stream, String oder Array](#stream-string-oder-array)
    * [Stream](#stream)
    * [Array](#array)
    * [String](#string)
<!-- TOC -->

## Befehlsreferenz

- [Dateisystem](https://www.php.net/manual/en/ref.filesystem.php)
- [Ordner](https://www.php.net/manual/en/ref.dir.php)
- [Konstanten](https://www.php.net/manual/en/reserved.constants.php)
- [Mehr Konstanten](https://www.php.net/manual/en/dir.constants.php)

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

### Array

````php
<?php
// HTML-Quelle
$lines = file('https://www.example.com/');

// Für jede Zeile HTML-Code als HTML-Code ausgeben:
foreach ($lines as $lineNum => $htmlCode) {
    
    echo "Line #<b>{$lineNum}</b> : " . htmlspecialchars($htmlCode) . "<br />\n";
}

// optionale Parameter: \n und leere Zeilen im Text ignorieren
$trimmed = file('datei.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
````

### String

````php
<?php
$homepage = file_get_contents('https://www.example.com/');
echo $homepage;
````

Wir können übrigens PHP-Objekte als ``string`` speichern. Dafür implementieren
wir die magischen Methoden ``__serialize()`` und ``__unserialize(data)``:

````php
<?php

class Character
{

    private string $attrib1 = "Held";
    private int $attrib2 = 340;
    private array $attrib3 = ["Holzschwert","Schild","Heiltrank"];
    
    // Objektzustand speichern
    public function __serialize(): array
    {
        // Festlegen, welche Attribute gespeichert werden sollen
        return [
                $this->attrib1,
                $this->attrib2,
                $this->attrib3,
            ];
    }
    
    // Objektzustand wiederherstellen
    public function __unserialize(array $data): void
    {
        // list() = $data; ist prima, wenn wir mehrere Attribute befüllen wollen
        list(
            $this->attrib1,
            $this->attrib2,
            $this->attrib3,
            ) = $data
        ;
        
        // alternativ:
        $this->attrib1 = $data[0];
        $this->attrib2 = $data[1];
        $this->attrib3 = $data[2];
    }
    
}
````

Nun können wir den Zustand des Objekts speichern oder laden (Spielstand):

````php
<?php
// speichern
file_put_contents("savegame.txt", serialize($object));

// laden
$object = unserialize(file_get_contents("savegame.txt"));
````