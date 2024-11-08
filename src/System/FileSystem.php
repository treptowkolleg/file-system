<?php

namespace App\System;

class FileSystem
{

    private string $path;

    public function __construct(string $path) {
        $this->path = ROOT_PATH.str_replace("/", DIRECTORY_SEPARATOR, $path);
    }

    public function readAsStream(string $file): void
    {
        $handle = fopen($this->path.$file, "rb");

        if(!$handle) exit("Kann Datei nicht öffnen: ".$file);

        $i = 1;
        while(!feof($handle)) {
            echo $i . ": " . fgets($handle);
            $i++;
        }
        fclose($handle);
    }

    // TODO: Methode zum Schreiben von Daten in eine Datei entwickeln.

}